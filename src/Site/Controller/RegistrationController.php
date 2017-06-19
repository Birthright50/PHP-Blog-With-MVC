<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 22.04.17
 * Time: 0:49
 */
namespace Birthright\Site\Controller;
use Birthright\Core\Service\UserService;
use Birthright\Site\Dto\UserDto;

class RegistrationController extends Controller
{
    /**
     * RegistrationController constructor.
     */
    private $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    function index()
    {
        $params = [];
        if (isset($_SESSION['notices']) || isset($_SESSION['userDto'])) {
            $params['notices'] = $_SESSION['notices'];
            $params['userDto'] = $_SESSION['userDto'];
            unset($_SESSION['notices']);
            unset($_SESSION['userDto']);
        }
        $this->view->render('registration/index', $params);
    }

    function create()
    {
        $registration_form = $_POST['reg'];
        $userDto = new UserDto($registration_form);
        $notices = $this->userService->checkUserDto($userDto);
        if (!count($notices)) {
            $this->userService->save($userDto);
            header('Location:/');
        } else {
            $_SESSION['notices'] = $notices;
            $_SESSION['userDto'] = $userDto;
            header('Location:/registration');
        }
        exit();
    }
}