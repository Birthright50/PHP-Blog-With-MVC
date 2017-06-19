<?php
/**
 * Created by PhpStorm.
 * User: Peter Kozlovsky
 * Date: 17.04.17
 * Time: 19:58
 */
require_once '../src/Core/Infrastructure/init.php';
use Birthright\Core\FrontController;

$frontController = new FrontController();
$frontController->run();
