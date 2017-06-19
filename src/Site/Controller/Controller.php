<?php

/**
 * Created by PhpStorm.
 * User: birthright
 * Date: 22.04.17
 * Time: 2:36
 */
namespace Birthright\Site\Controller;

use Birthright\Site\Views\View;

abstract class Controller
{
    protected $view;

    function __construct(){
        $this->view = new View();
    }
}