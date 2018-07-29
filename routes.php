<?php
require_once 'common/CommonFunctions.php';
require_once 'common/CommonUtility.php';

require_once 'models/UserModel.php';
require_once 'models/AdminModel.php';

require_once 'controller/UserController.php';
require_once 'controller/AdminController.php';
require_once 'controller/LoginRegisterController.php';
require_once 'controller/PagesController.php';


function call($controller, $action)
{
    switch (strtolower($controller)) {
        case 'user' :
            $controller = new UserController();
            break;
        case 'admin' :
            $controller = new AdminController();
            break;
        case 'login' :
            $controller = new LoginRegisterController();
            break;
        case 'pages' :
            $controller = new PagesController();
            break;
    }
    $controller->{$action} ();
}

$controllers = array(
    'user' => [
        'showProfile',
        'completeProfile',
        'showHomePage',
        'showMenuPage',
        'showMenuDetail',
        'showOrderList',
        'addToCart',
        'showCart',
        'proceedToCheckout',
        'placeOrder',
        'deleteUser'
    ],
    'admin' => [
        'showDashboard',
        'showOrderList',
        'showUserList',
        'showBranchList',
        'showMenuList',
        'showAddMenuItem',
        'showAdvertisementList',
        'showAddAdvertisement',
        'addMenuItem',
        'deleteAdvertisement',
        'deleteMenuItem'
    ],
    'login' => [
        'showLoginRegister',
        'login',
        'register',
        'logOut'
    ],
    'pages' => [
        'error'
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
