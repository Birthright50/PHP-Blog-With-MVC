<?php
/**
 * Created by PhpStorm.
 * User: Peter Kozlovsky
 * Date: 20.04.17
 * Time: 13:49
 */

// For authorization etc


error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Main constants
define('SECRET_KEY', '6LfRSyIUAAAAAKx0wWDNQ5ZQ1z2YKmEBPYfn3eOa');
define('REMEMBER_ME_COOKIE', 'remember-me');
define('USER_SESSION', 'user-session');
define('TOKEN_LENGTH', 32);
define('SERIES_LENGTH', 24);
define('TOKEN_VALIDITY_SECONDS', 60 * 60 * 24 * 30);

define('CORE_PATH', realpath(__DIR__ . '/..'));
define('SITE_PATH', realpath(CORE_PATH . '/../Site'));
define('PUBLIC_PATH', realpath(CORE_PATH . '/../../web'));
//require_once CORE_PATH . '/Infrastructure/autoload.func.php';
define('MVC_DEFAULT_CONTROLLER', 'Home');
//actions
define('MVC_INDEX_ACTION', 'index');
define('MVC_NEW_ACTION', 'new');
define('MVC_CREATE_ACTION', 'create');
define('MVC_SHOW_ACTION', 'show');
define('MVC_EDIT_ACTION', 'edit');
define('MVC_UPDATE_ACTION', 'update');
define('MVC_DESTROY_ACTION', 'destroy');
//if(!ob_start("ob_gzhandler")) ob_start();

//require_once CORE_PATH . '/FrontController.php';
//require_once CORE_PATH . '/infrastructure/ChromePhp.php';
//require_once CORE_PATH . '/infrastructure/Swiftmailer.php';
require_once CORE_PATH . '/../../vendor/autoload.php';
//require_once CORE_PATH . "/entity/UserEntity.php";
//require_once SITE_PATH . "/dto/UserDto.php";
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = base64_encode(bin2hex(random_bytes(32)));
}


