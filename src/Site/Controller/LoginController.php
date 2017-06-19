<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 24.04.17
 * Time: 18:32
 */
namespace Birthright\Site\Controller;
use Birthright\Core\Service as Service;
class LoginController extends Controller
{
    private $userService;
    private $persistenceLoginService;

    public function __construct()
    {
        parent::__construct();
        $this->persistenceLoginService = new Service\PersistentTokenBasedRememberMeService();
        $this->userService = new Service\UserService();
    }

    public function index()
    {
        $params = [];
        if (isset($_SESSION['notices'])) {
            $params['notices'] = $_SESSION['notices'];
            unset($_SESSION['notices']);
        }
        $this->view->render('login/index', $params);
    }

    public function process()
    {
        if (isset($_POST['submit']) && isset($_POST['name']) && isset($_POST['password'])) {
            $notices = [];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $user = (filter_var($name, FILTER_VALIDATE_EMAIL)) ?
                $this->userService->findByEmailOrUsername($name, '') : $this->userService->findByEmailOrUsername('', $name);
            if ($user) {
                if ($this->userService->checkPasswords($password, $user->getPassword())) {
                    $user->setPassword(null);
                    $_SESSION[USER_SESSION] = $user;
                    if (isset($_POST['remember-me'])) {
                        $this->persistenceLoginService->onLoginSuccess($user);
                    }
                } else {
                    $notices['password'] = "Неправильно введен пароль";
                }
            } else {
                $notices['name'] = "Пользователь не найден";
            }
            if (count($notices)) {
                $_SESSION['notices'] = $notices;
                header('Location:/login');
            } else {
                header('Location:/');
            }
        } else {
            header('Location:/login');
        }
        exit();
    }
}