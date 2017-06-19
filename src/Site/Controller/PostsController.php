<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 15.06.17
 * Time: 3:02
 */
namespace Birthright\Site\Controller;
use Birthright\Core\Service\PostsService;
use Birthright\Site\Dto\PostDto;

class PostsController extends Controller
{

    private $postsService;
    private $path;
    private $userId;
    private $renderPage;
    private $includeCover;

    /**
     * @param PostsService $postsService
     */
    public function setPostsService(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @param null $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param string $renderPage
     */
    public function setRenderPage(string $renderPage)
    {
        $this->renderPage = $renderPage;
    }

    /**
     * @param bool $includeCover
     */
    public function setIncludeCover(bool $includeCover)
    {
        $this->includeCover = $includeCover;
    }

    public function __construct($path = '/posts/page', $userId = null, $renderPage = 'posts/index', bool $includeCover = false)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->path = $path;
        $this->includeCover = $includeCover;
        $this->renderPage = $renderPage;
        $this->postsService = new PostsService();
    }

    public function page($page)
    {
        $params = [];
        $posts = $this->postsService->findAllByPage($page, $this->userId, $this->includeCover);
        if (count($posts)) {
            $params['posts'] = $posts;
            $params['count'] = $posts[0]['count'];
            $params['pager'] = $this->postsService->createPagination($page, $posts[0]['count'], $this->path);
            if ($this->includeCover) {
                $params['title'] = $posts[0]['username'];
                $params['cover'] = $posts[0]['cover'];
            }
        }
        $this->view->render($this->renderPage, $params);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->postsService->deleteById((int)$id);
            header('Content-Type: application/json');
            echo json_encode("OK");
        }
    }

    public function new_()
    {
        if (isset($_SESSION[USER_SESSION])) {
            $params = [];
            if (isset($_SESSION['notices']) || isset($_SESSION['postDto'])) {
                $params['notices'] = $_SESSION['notices'];
                $params['postDto'] = $_SESSION['postDto'];
                unset($_SESSION['notices']);
                unset($_SESSION['postDto']);
            }
            $this->view->render("posts/new", $params);
        } else {
            header('Location:/');
        }
    }

    public function create()
    {
        if (isset($_SESSION[USER_SESSION]) && $_SERVER['REQUEST_METHOD'] == 'POST'
        && isset($_POST['text']) && isset($_POST['title'])) {
            $postDto = new PostDto($_POST['text'], $_POST['title']);
            $notices = $this->postsService->validatePost($postDto);
            if (!count($notices)) {
                $id = $this->postsService->save($postDto);
                header('Location:/posts/show/' . $id);
            } else {
                $_SESSION['notices'] = $notices;
                $_SESSION['postDto'] = $postDto;
                header('Location:/posts/new_');
            }
        } else {
            header('Location:/');
        }
        exit();
    }

    public function show($id)
    {
        $arr = $this->postsService->findPostsAndCommentsByPostId((int)$id);
        $arr['comment_id'] = isset($_SESSION['comment_id']) ? $_SESSION['comment_id'] : 0;
        unset($_SESSION['comment_id']);
        $this->view->render("posts/show", $arr);
    }
}