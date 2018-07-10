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
    private $profileInformation;

    public function showHomePage()
    {
        require_once 'views/title.inc.php';
        require_once 'views/user/home_page.php';
        require_once 'views/tail.inc.php';
    }

}
