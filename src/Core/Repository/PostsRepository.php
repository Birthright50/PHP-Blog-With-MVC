<?php
namespace Birthright\Core\Repository;
use Birthright\Site\Dto\PostDto;
use PDO;
use PDOException;

class PostsRepository extends Repository
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function save(PostDto $postDto): int
    {
        $DBO = $this->openConnection();
        $user_session = $_SESSION[USER_SESSION];
        $STH = $DBO->prepare("INSERT INTO posts (text, user_id, title, created, cover) VALUES (:text, :user_id, :title, NOW(), :cover)");
        try {
            $DBO->beginTransaction();
            $STH->execute([':text' => $postDto->getText(), ':user_id' => $user_session->getId(), ':title' => $postDto->getTitle(), ':cover' => $postDto->getCover()]);
            $id = $DBO->lastInsertId();
            $DBO->commit();
        } catch (PDOException $e) {
            $DBO->rollBack();
            header("Location:/");
            exit();
        }
        $this->closeConnection();
        return (int)$id;
    }

    public function findAllByPage(int $page, int $countPerPage, $userId = null, bool $includeCover = false)
    {
        $DBO = $this->openConnection();
        $preparedArray = [':left' => ($page - 1) * $countPerPage, ':right' => $page * $countPerPage];

        $preparedString = "SELECT (SELECT count(*) FROM posts";
        if (!is_null($userId)) {
            $preparedString .= " WHERE posts.user_id=:user_id";
            $preparedArray[':user_id'] = $userId;
        }
        $preparedString .= ") AS count,  *
FROM    ( SELECT ROW_NUMBER() OVER ( ORDER BY posts.created DESC ) AS RowNum, posts.created,posts.id, users.username, posts.title, posts.user_id";
        if ($includeCover) {
            $preparedString .= " , users.cover ";
        }
        $preparedString .= " FROM posts INNER JOIN users ON posts.user_id = users.id ";
        if (!is_null($userId)) {
            $preparedString .= " WHERE users.id=:user_id";
        }
        $preparedString .= ") AS RowConstrainedResult
WHERE   RowNum > :left
        AND RowNum <= :right;";
        $STH = $DBO->prepare($preparedString);
        $STH->execute($preparedArray);
        $rows = $STH->fetchAll(PDO::FETCH_ASSOC);
        $this->closeConnection();
        return $rows;
    }

    public function deleteById(int $id): void
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("DELETE FROM posts WHERE id=:id");
        $STH->execute([':id' => $id]);
        $this->closeConnection();
    }

    public function findCommentsAndPostsByPostId(int $id): array
    {
        $arr = [];
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("SELECT posts.id, posts.title, posts.cover, posts.text, posts.user_id, users.username,
 posts.created FROM posts INNER JOIN users ON posts.user_id = users.id WHERE posts.id=:id");
        $STH->execute([':id' => $id]);
        $post = $STH->fetch(PDO::FETCH_ASSOC);
        $arr['post'] = $post ? $post : null;
        $STH = $DBO->prepare("SELECT comments.created, comments.user_id,comments.id, 
comments.text, comments.parent_id, users.username, users.avatar
 FROM comments INNER JOIN users ON comments.user_id = users.id WHERE comments.post_id=:id ORDER BY comments.created DESC");
        $STH->execute([':id' => $id]);
        $comments = $STH->fetchAll(PDO::FETCH_ASSOC);
        $arr['comments'] = $comments ? $comments : [];
        $this->closeConnection();
        return $arr;
    }
}