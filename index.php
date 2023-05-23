<?php
//ini_set('display_errors', 1);
//error_reporting(E_ERROR);
define("PATH", "https://imdibil.ru/hackathon/web/");
define("ROOT", $_SERVER['DOCUMENT_ROOT']."/hackathon/web/");

if($_GET['route'])
{
    $route = explode('/',$_GET['route']);
} else
{
    $route[0] = '/';
}

if($route[0] == 'api')
{
    require_once 'web/controller/api/controller.php';
} else
{
    require_once 'web/controller/controller.php';
}

