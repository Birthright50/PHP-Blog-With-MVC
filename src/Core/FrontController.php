<?php

/**
 * Created by PhpStorm.
 * User: Peter Kozlovsky
 * Date: 22.04.17
 * Time: 16:03
 */
namespace Birthright\Core;

use Birthright\Core\Service\PersistentTokenBasedRememberMeService;
use Birthright\Site\Views\View;
use ReflectionClass;

class FrontController
{
    private $view;
    private $controller = 'Birthright\Site\Controller\\'.MVC_DEFAULT_CONTROLLER . "Controller";
    private $action = MVC_INDEX_ACTION;
    private $params = [];
    private $persistenceLoginService;

    /**
     * FrontController constructor.
     */
    public function __construct()
    {
        $this->view = new View();
        $this->persistenceLoginService = new PersistentTokenBasedRememberMeService();
    }

    public function run()
    {
        $this->processAuthentication();
        $this->parseUri();
        call_user_func_array([new $this->controller, $this->action], $this->params);
    }

    private function processAuthentication()
    {
        if (!isset($_SESSION[USER_SESSION]) && isset($_COOKIE[REMEMBER_ME_COOKIE])) {
            $this->persistenceLoginService->processAutoLoginCookie();
        }
    }

    private function parseUri()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                header("Location:/");
                exit();
            }
            $this->action = MVC_CREATE_ACTION;
        }
        $request_uri_info = parse_url($_SERVER['REQUEST_URI']);
        $requestPaths = explode('/', $request_uri_info['path']);
        // Get controller name
        if (!empty($requestPaths[1])) {

            $this->setController($requestPaths[1]);
        }
        // Get action name
        if (!empty($requestPaths[2])) {
            $this->setAction(strtolower($requestPaths[2]));
        }else{
            $this->setAction($this->action);
        }
        // Get Path params
        if (count($requestPaths) >= 3) {
            $this->setParams(array_slice($requestPaths, 3));
        }
    }

    private function setController($controllerName)
    {
        $controller = 'Birthright\Site\Controller\\'.ucfirst(strtolower($controllerName)) . "Controller";
        if (!class_exists($controller)) {
            $this->view->render('404');
            exit();
        }
        $this->controller = $controller;
    }

    private function setAction($action)
    {
        $reflector = new ReflectionClass($this->controller);
        if (!$reflector->hasMethod($action)) {
            $this->view->render('404');
            exit();
        }
        $this->action = $action;
        return $this;
    }

    private function setParams(array $params)
    {
        $this->params = $params;
    }
}