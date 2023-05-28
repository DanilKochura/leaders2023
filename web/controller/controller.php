<?php

ini_set('display_errors', 1);
error_reporting(E_ERROR);
global $route;

require_once ROOT.'model/DB.php';
require_once ROOT.'views/inc/header.php';
$alphabet = range("A", "Z");

if($route[0] == '/')
{

    require_once ROOT.'/views/dynamic.php';
} elseif ($route[0] == 'dynamic')
{
    require_once ROOT.'/views/dynamic.php';
}elseif ($route[0] == 'seasons')
{
    require_once ROOT.'/views/seasons.php';
}elseif ($route[0] == 'profiles')
{
//    require_once ROOT.'/views/profiles.php';
}elseif ($route[0] == 'predicts')
{
    require_once ROOT.'/views/predicts.php';
}
require_once ROOT.'/views/inc/footer.php';

