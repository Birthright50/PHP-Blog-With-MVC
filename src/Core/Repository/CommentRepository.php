<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 15.06.17
 * Time: 22:43
 */
namespace Birthright\Core\Repository;
use PDOException;

class CommentRepository extends Repository
{

    public function save($postId, $text, $userId, $parentId): int
    {
        $DBO = $this->openConnection();
        $STH = $DBO->prepare("INSERT INTO comments (text, created, user_id, post_id, parent_id)
  VALUES (:text, now(), :user_id, :post_id, :parent_id)");
        try {
            $DBO->beginTransaction();
            $STH->execute([':text' => $text, ':user_id' => $userId,
                ':post_id' => $postId, ':parent_id' => $parentId]);
            $id = $DBO->lastInsertId();
            $DBO->commit();
        } catch (PDOException $e) {
            $DBO->rollBack();
            header("Location:/");
            exit();
        }
        $this->closeConnection();
        if (!$id) {
            header("Location:/");
            exit();
        }
        return (int)$id;

    }
}