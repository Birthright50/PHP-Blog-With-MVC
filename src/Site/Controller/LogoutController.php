<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 11.05.17
 * Time: 1:48
 */
namespace Birthright\Site\Controller;
use Birthright\Core\Service\PersistentTokenBasedRememberMeService;

class LogoutController extends Controller
{
    private $persistenceLoginService;

    public function __construct()
    {
        parent::__construct();
        $this->persistenceLoginService = new PersistentTokenBasedRememberMeService();
    }

    function process()
    {
        if (isset($_SESSION[USER_SESSION])) {
            $this->persistenceLoginService->logout();
            unset($_SESSION[USER_SESSION]);
        }
        header('Location:/');
        exit();
    }

}