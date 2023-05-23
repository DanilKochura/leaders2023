<?php
global $route;

require_once ROOT.'/views/inc/header.php';
if($route[0] == '/')
{
    require_once ROOT.'/views/index.php';
    require_once ROOT.'/views/inc/footer.php';
}

