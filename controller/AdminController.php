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
    private $news;
    private $advertisements;
    private $orderList;

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

    private function getAllNews()
    {
        $this->news = AdminModel::getAllNews();
    }

    private function getAllAdvertisements()
    {
        $this->advertisements = AdminModel::getAllAdvertisements();
    }

    public function showDashboard()
    {
        require_once 'views/admin.title.inc.php';
        require_once 'views/admin/admin_panel.php';
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
        $this->orderList = UserModel::getAllOrders();
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
        AdminModel::addNews($_POST);

        $adInfo = AdminModel::getLastInsertedNews();
        $adInfo = $adInfo['id'];

        if ($_FILES['img01']['name']) {
            $this->addPicture($adInfo, 'news');
        }

        $path = '?controller=admin&action=showNewsList';
        CommonUtility::redirect($path);
    }

    private function addPicture($id, $type)
    {
        $image01 = $_FILES['img01']['name'];
        //$image01_ = 1 . substr($image01, strpos($image01, "."));
        $imgTarget = "uploads/$type/img/" . $id;
        if (!file_exists($imgTarget)) {
            mkdir($imgTarget, 0777, true);
        }
        move_uploaded_file($_FILES['img01']['tmp_name'], $imgTarget . "/" . $image01);
        AdminModel::addPicture($id, $image01, $type);
    }

    public function deleteNews()
    {
        if ($this->userInformation['user_type'] == 'admin') {
            AdminModel::deleteNews($_GET['id']);
        }
        $path = '?controller=admin&action=showNewsList';
        CommonUtility::redirect($path);

    }
    public function deleteAd()
    {
        if ($this->userInformation['user_type'] == 'admin') {
            AdminModel::deleteAd($_GET['id']);
        }
        $path = '?controller=admin&action=showAdvertisementList';
        CommonUtility::redirect($path);

    }

}
