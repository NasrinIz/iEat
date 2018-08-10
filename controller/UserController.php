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
    private $advertisements;
    private $orderDetail;

    public function __construct()
    {
        $this->getUserInformation();
        $this->getAllAdvertisements();
    }

    private function getUserInformation()
    {
        $this->userInformation = UserModel::getUserByEmail($_SESSION['email']);
    }

    private function getAllAdvertisements()
    {
        $this->advertisements = AdminModel::getAllAdvertisements();
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
        require_once 'views/user/homePage.php';
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
        $orderTime = AdminModel::getOrderTime(1);

        $currentHour = date('H');

        /* if((strtotime($orderTime['order_time_from']) <= strtotime($currentHour)) AND (strtotime($currentHour)<=strtotime($orderTime['order_time_to']))) {*/

        UserModel::addOrder($_POST);
        $cartInfo = UserModel::getCartInfo();
        $orderInfo = UserModel::getLastInsertedOrder();
        foreach ($cartInfo as $key=>$value){
            UserModel::addOrderDetail($value, $orderInfo['order_id']);
        }
        UserModel::deleteCartInfo();
        if (!empty($this->userInformation)) {
            $this->showOrderList();
        } else {
            $this->notification = CommonUtility::showNotification('Your order has been registered successfully.', 'success');
            $this->showHomePage();
        }
        /*  }else{
              $msg = 'The order time is between ' . $orderTime['order_time_from'] . 'and ' .$orderTime['order_time_to'];
              $this->notification = CommonUtility::showNotification($msg, 'warning');
              $this->showMenuPage();
          }*/
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

    public function showOrderDetail()
    {
        $this->orderDetail = UserModel::getOrderDetailByOrderId($_GET['id']);
        require_once 'views/title.inc.php';
        require_once 'views/user/orderDetail.php';
        require_once 'views/tail.inc.php';
    }

    public function completeProfile()
    {
        UserModel::completeProfile($_POST);
        $path = '?controller=user&action=showProfile';
        CommonUtility::redirect($path);

    }

}
