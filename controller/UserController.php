<?php

/**
 * Contains all user actions
 * @author NI
 */
class UserController
{
    /**
     * Notification alert in every page
     */
    private $notification;

    private $userInformation;
    private $orderList;
    private $menuList;
    private $subMenu;
    private $menuDetail;
    private $cartInfo;

    public function __construct()
    {
        $this->getUserInformation();
    }

    private function getUserInformation()
    {
        $this->userInformation = UserModel::getUserByEmail($_SESSION['email']);
    }

    public function showProfile()
    {
        require_once 'views/title.inc.php';
        require_once 'views/user/profile.php';
        require_once 'views/tail.inc.php';
    }

    public function showHomePage()
    {
        require_once 'views/title.inc.php';
        require_once 'views/user/home_page.php';
        require_once 'views/tail.inc.php';
    }

    public function showMenuPage()
    {
        $this->menuList = UserModel::getAllMenus();
        require_once 'views/title.inc.php';
        require_once 'views/user/menu.php';
        require_once 'views/tail.inc.php';
    }

    public function showMenuDetail()
    {
        $this->menuDetail = UserModel::getMenuById($_GET['menuId']);
        require_once 'views/title.inc.php';
        require_once 'views/user/menuDetail.php';
        require_once 'views/tail.inc.php';
    }

    public function showOrderList()
    {
        $this->orderList = UserModel::getAllOrders($this->userInformation['id']);
        require_once 'views/title.inc.php';
        require_once 'views/user/orderList.php';
        require_once 'views/tail.inc.php';
    }

    public function addToCart()
    {

        UserModel::addToCart($_POST);
        $this->showCart();
    }

    public function showCart()
    {
        $this->cartInfo = UserModel::getCartInfo();
        require_once 'views/title.inc.php';
        require_once 'views/user/cart.php';
        require_once 'views/tail.inc.php';
    }

    public function placeOrder()
    {
        UserModel::addOrder($_POST);
        require_once 'views/title.inc.php';
        require_once 'views/user/orderList.php';
        require_once 'views/tail.inc.php';
    }

    public function proceedToCheckout()
    {
        $this->cartInfo = UserModel::getCartInfo();
        require_once 'views/title.inc.php';
        require_once 'views/user/checkout.php';
        require_once 'views/tail.inc.php';
    }

    public function deleteUser()
    {
        if ($this->userInformation['user_type'] == 'admin') {
            UserModel::deleteUser($_GET['id']);
        }
        $path = '?controller=admin&action=showUserList';
        CommonUtility::redirect($path);

    }

}
