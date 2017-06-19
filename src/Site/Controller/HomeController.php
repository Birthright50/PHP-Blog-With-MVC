<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 22.04.17
 * Time: 0:59
 */
namespace Birthright\Site\Controller;
use Birthright\Core\Service\PostsService;

class HomeController extends Controller
{

    private $postsService;
    private $postController;

    public function __construct()
    {
        parent::__construct();
        $this->postsService = new PostsService();
        $this->postController = new PostsController();
    }

    function index()
    {
        $this->postController->page(1);
    }


}