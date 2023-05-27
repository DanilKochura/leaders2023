<?php
ini_set('display_errors', 0);
error_reporting(E_ERROR);
//define("PATH", "https://imdibil.ru/hackathon/web/");
define("PATH", "https://imdibil.ru/hackathon/web/");
define("ROOT", $_SERVER['DOCUMENT_ROOT']."/hackathon/web/");
////echo file_get_contents('run.py'); die();
//$command = escapeshellcmd('python run.py');
//$output = shell_exec($command);
//echo $output;
//die();
//$resp = shell_exec('python3 run.py a'); var_dump($resp); die;

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

