<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 15.06.17
 * Time: 3:14
 */
namespace Birthright\Site\Controller;
class UserController extends Controller
{
    private $postsController;

    public function __construct()
    {
        parent::__construct();
        $this->postsController = new PostsController('/user/show', 0, 'posts/index', true);
    }

    public function show($userId, $page = 1)
    {
        $this->postsController->setUserId($userId);
        $this->postsController->setPath('/user/show/' . $userId);
        $this->postsController->page($page);

    }
}