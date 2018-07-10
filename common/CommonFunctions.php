<?php

/**
 * This class contains common utility functions.
 * These are do-not-repeat-yourself functions.
 * @author NI
 */
class CommonFunctions
{

    /**
     * SESSION variables.
     * @param $email - the user email
     * @return array $list
     */
    public static function UserData($email)
    {
        $list = [];
        $db = Db::getInstance();
        $result = $db->query("SELECT "
            . "`username`"
            . "FROM `users` "
            . "WHERE `username`='$email'");

        foreach ($result->fetchAll() as $user) {
            $list[] = new UserModel(
                $user['email']
            );
        }
        return $list;
    }

    /**
     * SESSION variables.
     * @param $email - the admin email
     * @return array $list
     */
    public static function AdminData($email)
    {
        $list = [];
        $db = Db::getInstance();
        $result = $db->query("SELECT "
            . "`username`"
            . "FROM `admin` "
            . "WHERE `username`='$email'");

        foreach ($result->fetchAll() as $admin) {
            $list[] = new UserModel(
                $admin['email']
            );
        }
        return $list;
    }

    /**
     * @return bool
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['email']) || isset($_SESSION['email']);
    }

}
