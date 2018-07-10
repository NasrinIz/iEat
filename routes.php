<?php
require_once 'common/CommonFunctions.php';
require_once 'common/CommonUtility.php';

require_once 'models/UserModel.php';

require_once 'controller/UserController.php';
require_once 'controller/AdminController.php';



function call($controller, $action)
{
    switch (strtolower($controller)) {
        case 'user' :
            $controller = new UserController();
            break;
    }
    $controller->{$action} ();
}

$controllers = array(
    'user' => [
        'showHomePage'
    ]
);

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers [$controller])) {
        call($controller, $action);
    } else {
        call('pages', 'error');
    }
} else {
    call('pages', 'error');
}
