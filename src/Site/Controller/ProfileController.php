<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 15.06.17
 * Time: 1:58
 */
namespace Birthright\Site\Controller;
use Birthright\Core\Service\PostsService;

class ProfileController extends Controller
{

    private $postsService;
    private $postsController;

    public function __construct()
    {
        if (!isset($_SESSION[USER_SESSION])) {
            header('Location:/');
            exit();
        }
        parent::__construct();
        $this->postsService = new PostsService();
        $this->postsController = new PostsController('/profile/page', $_SESSION[USER_SESSION]->getId(), 'profile/index');
    }

    function index()
    {
        $this->postsController->page(1);
    }

    function page($page)
    {
        $this->postsController->page($page);

    }
}