<?php
namespace Birthright\Site\Views;

define('VIEWS_BASEDIR', SITE_PATH . '/Views/');

class View
{
// получить отрендеренный шаблон с параметрами $params
    function fetch($template, $params = [])
    {
        extract($params);
        ob_start();
        include_once VIEWS_BASEDIR . $template . '.inc.php';
        return ob_get_clean();
    }

    // вывести отрендеренный шаблон с параметрами $params
    function render($template, $params = [])
    {
        echo $this->fetch($template, $params);
    }
}