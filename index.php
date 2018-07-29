<?php
error_reporting(1);
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
ini_set('display_errors',1);
require_once('connection.php');

define("PATH_DIR","http://".$_SERVER['HTTP_HOST']."/");
define("ROOT_DIR",dirname(__FILE__) ."/");
define("PROJECT_DIR","http://".$_SERVER['HTTP_HOST']."/iEat/");

if (isset($_GET['controller']) && isset($_GET['action']))
{
    $controller = $_GET['controller'];
    $action = $_GET['action'];
}
else
{
    $controller = 'user';
    $action = 'showHomePage';
}

require_once('routes.php');



