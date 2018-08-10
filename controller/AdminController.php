<?php

/**
 * Contains all user actions
 * @author NI
 */
class AdminController
{
    /**
     * Notification alert in every page
     */
    private $notification;

    private $userInformation;
    private $advertisements;
    private $adDetail;
    private $menuItem;
    private $orderList;
    private $menuList;
    private $orderTime;

    public function __construct()
    {
        $this->getUserInformation();
        if ($this->userInformation['is_admin'] != 1) {
            $path = '?controller=user&action=showHomePage';
            CommonUtility::redirect($path);
        }
    }

    private function getUserInformation()
    {
        $this->userInformation = UserModel::getUserByEmail($_SESSION['email']);
    }

    private function getOrderTime()
    {
        $this->orderTime = AdminModel::getOrderTime(1);
    }

    private function getAllAdvertisements()
    {
        $this->advertisements = AdminModel::getAllAdvertisements();
    }

    public function showDashboard()
    {
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/adminPanel.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showBranchList()
    {
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/branchList.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showOrderList()
    {
        $this->orderList = AdminModel::getAllOrders();
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/orderList.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showUserList()
    {
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/userList.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showMenuList()
    {
        $this->menuList = AdminModel::getAllMenus();
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/menuList.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showAddMenuItem()
    {
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/addMenuItem.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showAdList()
    {
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/advertisementList.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showAddAdvertisement()
    {
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/addAdvertisement.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showAdvertisementList()
    {
        $this->getAllAdvertisements();
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/advertisementList.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showSetTime()
    {
        $this->getOrderTime();
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/setTime.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function setTime()
    {
        AdminModel::setOrderTime($_POST, 1);

        $path = '?controller=admin&action=showSetTime';
        CommonUtility::redirect($path);
    }


    public function addAdvertisement()
    {
        AdminModel::addAdvertisement($_POST);

        $adInfo = AdminModel::getLastInsertedAd();
        $adInfo = $adInfo['id'];

        if ($_FILES['img01']['name']) {
            $this->addPicture($adInfo, 'advertisements');
        }

        $path = '?controller=admin&action=showAdvertisementList';
        CommonUtility::redirect($path);
    }

    public function changeStatus()
    {
        AdminModel::changeStatus($_GET['id'], $_GET['status']+ 1);

       $this->showOrderList();
    }

    public function addMenuItem()
    {
        AdminModel::addMenuItem($_POST);

        $menuInfo = AdminModel::getLastInsertedMenuItem();
        $menuId = $menuInfo['id'];

        if ($_FILES['img01']['name']) {
            $this->addPicture($menuId, 'menus');
        }

        $path = '?controller=admin&action=showMenuList';
        CommonUtility::redirect($path);
    }

    private function addPicture($id, $type)
    {
        $image01 = $_FILES['img01']['name'];
        //$image01_ = 1 . substr($image01, strpos($image01, "."));
        $imgTarget = "uploads/".$type."/". $id;

        if (!file_exists($imgTarget)) {
            mkdir($imgTarget, 0777, true);
        }
        move_uploaded_file($_FILES['img01']['tmp_name'], $imgTarget . "/" . $image01);
        AdminModel::addPicture($id, $image01, $type);
    }

    public function editAd()
    {
        AdminModel::editAd($_POST);
        $path = '?controller=admin&action=showAdvertisementList';
        CommonUtility::redirect($path);
    }

    public function showEditAd()
    {
        $this->adDetail = AdminModel::getAdById($_GET['id']);
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/editAd.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function showEditMenuItem()
    {
        $this->menuItem = AdminModel::getMenuItemById($_GET['id']);
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/editMenuItem.php';
        require_once 'views/admin.tail.inc.php';
    }

    public function editMenuItem()
    {
        AdminModel::editMenuItem($_POST);
        $path = '?controller=admin&action=showMenuList';
        CommonUtility::redirect($path);
    }

    public function deleteAd()
    {
        if ($this->userInformation['is_admin'] == 1) {
            AdminModel::deleteAd($_GET['id']);
        }
        $path = '?controller=admin&action=showAdvertisementList';
        CommonUtility::redirect($path);

    }

    public function deleteMenuItem()
    {
        if ($this->userInformation['is_admin'] == 1) {
            AdminModel::deleteMenuItem($_GET['id']);
        }
        $path = '?controller=admin&action=showMenuList';
        CommonUtility::redirect($path);

    }

}
