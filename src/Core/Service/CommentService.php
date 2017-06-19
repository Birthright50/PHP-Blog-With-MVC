<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 15.06.17
 * Time: 22:07
 */
namespace Birthright\Core\Service;
use Birthright\Core\Repository\CommentRepository;

class CommentService
{
    private $commentRepository;

    public function __construct()
    {
        $this->commentRepository = new CommentRepository();
    }

    public function saveComment(): int
    {
        if (!isset($_POST['post_id']) || !isset($_POST['text'])) {
            header("Location:/");
            exit();
        }
        $postId = $_POST['post_id'];
        $text = $_POST['text'];
        $userId = $_SESSION[USER_SESSION]->getId();
        if (isset($_POST['parent_id'])) {
            $parentId = $_POST['parent_id'];
        } else {
            $parentId = null;
        }
        return $this->commentRepository->save($postId, $text, $userId, $parentId);

    }
}