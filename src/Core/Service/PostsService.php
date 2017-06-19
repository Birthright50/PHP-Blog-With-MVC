<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 24.04.17
 * Time: 14:03
 */
namespace Birthright\Core\Service;
use Birthright\Site\Dto\PostDto;
use HTMLPurifier;
use Ramsey\Uuid\Uuid;
use Birthright\Core\Repository as Repository;

class PostsService
{
    private $userRepository;
    private $postsRepository;
    private $countPerPage;

    public function __construct()
    {
        $this->userRepository = new Repository\UserRepository();
        $this->postsRepository = new Repository\PostsRepository();
        $this->countPerPage = 10;
    }

    public function save(PostDto &$postDto): int
    {
      return $this->postsRepository->save($postDto);
    }

    public function findAllByPage($page, $userId = null, bool $includeCover = false)
    {
        return $this->postsRepository->findAllByPage($page, $this->countPerPage, $userId, $includeCover);
    }

    public function createPagination($page, $count, $path = '/posts/page'): array
    {
        $lastPage = intdiv($count, $this->countPerPage);
        if ($count % $this->countPerPage !== 0) {
            $lastPage += 1;
        }
        return $this->makePager((int)$page, (int)$lastPage, 3, 4, $path);
    }

    private function makeLi(bool $insertHref, $page, $path)
    {
        if ($insertHref) {
            return '<li class="next">
                    <a href="' . $path . '/' . $page . '">' . $page . '</a></li>';
        }
        return '<li class="next">
                    <a style="text-decoration: underline;">' . $page . '</a>
                </li>';
    }

    private function makePager(int $currentPage, int $lastPage, int $leftLimit, int $rightLimit, $path): array
    {
        $pager = [];
        if ($currentPage > $leftLimit && $currentPage < ($lastPage - $rightLimit)) {
            $pager[] = $this->makeLi(true, 1, $path);
            $pager[] = $this->makeLi(false, '...', $path);
            for ($i = $currentPage - $leftLimit + 1; $i <= $currentPage + $rightLimit - 1; $i++) {
                $pager[] = $i !== $currentPage
                    ? $this->makeLi(true, $i, $path) : $this->makeLi(false, $i, $path);
            }
            $pager[] = $this->makeLi(false, '...', $path);
            $pager[] = $this->makeLi(true, $lastPage, $path);
        } elseif ($currentPage <= $leftLimit) {
            $iSlice = 1 + $leftLimit - $currentPage;
            for ($i = 1; $i <= $currentPage + ($rightLimit + $iSlice) && $i <= $lastPage; $i++) {
                $pager[] = $i !== $currentPage
                    ? $this->makeLi(true, $i, $path) : $this->makeLi(false, $i, $path);
            }
            if ($lastPage > $this->countPerPage) {
                $pager[] = $this->makeLi(false, '...', $path);
                $pager[] = $this->makeLi(true, $lastPage, $path);
            }
        } else {
            if ($lastPage > $this->countPerPage) {
                $pager[] = $this->makeLi(true, 1, $path);
                $pager[] = $this->makeLi(false, '...', $path);
            }
            $iSlice = $rightLimit - ($lastPage - $currentPage);
            for ($i = $currentPage - ($leftLimit + $iSlice); $i <= $lastPage; $i++) {
                $pager[] = $i !== $currentPage ?
                    $this->makeLi(true, $i, $path)
                    : $this->makeLi(false, $i, $path);
            }
        }
        return $pager;
    }

    public function deleteById(int $id): void
    {
        $this->postsRepository->deleteById($id);
    }

    public function validatePost(PostDto &$postDto): array
    {
        $purifier = new HTMLPurifier();
        $notices = [];
        $postDto->setTitle(strip_tags($postDto->getTitle()));
        $cover = $_FILES['cover'];
        if (strlen(utf8_decode($postDto->getTitle())) < 5) {
            $notices['title'] = "Длина заголовка меньше 5 символов.";
        }
        $postDto->setText($purifier->purify($postDto->getText()));
        if (strlen($postDto->getText()) < 30) {
            $notices['text'] = "Длина текста меньше 30 символов.";
        }
        $this->uploadImg($cover, $notices, $postDto);
        return $notices;
    }

    private function uploadImg($file, &$notices, PostDto &$postDto):void
    {
        $targetDirectory = PUBLIC_PATH . "/resources/images/covers/";
        $targetFile = $targetDirectory . basename($file["name"]);
        $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);
        if (!exif_imagetype($file['tmp_name'])) {
            $notices['cover'] = "Обложка не является изображением";
            return;
        }
        if ($file["size"] > 50000000) {
            $notices['cover'] = "Слишком большой размер обложки";
            return;
        }
        $uuid4 = Uuid::uuid4();
        $uuid = $uuid4->toString();
        $destination = $targetDirectory . $uuid . '.' . $imageFileType;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $notices['avatar'] = "Произошла ошибка при загрузке";
            return;
        }
       $postDto->setCover("/resources/images/covers/" . $uuid . '.' . $imageFileType);

    }

    public function findPostsAndCommentsByPostId(int $id):array
    {
     $arr = $this->postsRepository->findCommentsAndPostsByPostId($id);
     $arr['counts'] = sizeof($arr['comments']);
     $this->prepareComments($arr);
     return $arr;
    }

    private function prepareComments(array &$arr)
    {
        $comments = &$arr['comments'];
        $preparedComments = [];
        foreach ($comments as $key =>&$value){
            $value['childs'] = [];
            $preparedComments[$value['id']] = $value;
        }
        unset($value);
        unset($comments);
        foreach ($preparedComments as  &$value) {
            if (!is_null($value['parent_id'])) {
                $preparedComments[$value['parent_id']]['childs'][] =$value;
            }
        }
        unset($value);
        foreach ($preparedComments as $k => $value) {
            if (!is_null($value['parent_id'])) {
                unset($preparedComments[$k]);
            }
        }
        $arr['comments'] = &$preparedComments;
    }


}