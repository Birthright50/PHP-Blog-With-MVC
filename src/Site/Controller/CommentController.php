<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 15.06.17
 * Time: 22:05
 */
namespace Birthright\Site\Controller;

use Birthright\Core\Service\CommentService;

class CommentController extends Controller
{
    private $commentService;

    public function __construct()
    {
        if (!isset($_SESSION[USER_SESSION]) || $_SERVER['REQUEST_METHOD'] != 'POST') {
          header("Location:/");
          exit();
        }
        parent::__construct();
        $this->commentService = new CommentService();
    }

    public function create()
    {
        $id = $this->commentService->saveComment();
        $_SESSION['comment_id'] = $id;
        header("Location:/posts/show/".$_POST['post_id']);
        exit();
    }
}