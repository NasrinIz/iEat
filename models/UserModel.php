<?php
/**
 * Created by PhpStorm.
 * User: Beaver2
 * Date: 2018-06-14
 * Time: 11:31
 */

class UserModel
{
    /**
     * Get all users
     * @return string
     */
    public static function getAllUsers()
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM users_info";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Get all orders
     * @return string
     */
    public static function getAllOrders()
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM orders";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }


    /**
     * Get cart
     * @return string
     */
    public static function getCartInfo()
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM cart";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Get all menus
     * @return string
     */
    public static function getAllMenus()
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM menus";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Get menu by Id
     * @param $id
     * @return string
     */
    public static function getMenuById($id)
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM menus WHERE menu_id = $id";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Get all sub menus
     * @param $id
     * @return string
     */
    public static function getAllSubMenus($id)
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM sub_menus WHERE menu_id=$id";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

 /**
     * Get user by email
     * @param $email
     * @return string
     */
    public static function getUserByEmail($email)
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM users WHERE username = '$email'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }


    /**
     * Get owner profile info by email
     * @param $type
     * @param $email
     * @return string
     */
    public static function getProfileInformationByEmail($email, $type)
    {

        if($type == 'vendor'){
            $db = Db::getInstance();
            $sql = "SELECT * FROM vendor_infos WHERE email = '$email'";
        }else if ($type == 'owner'){
            $db = Db::getInstance();
            $sql = "SELECT * FROM owner_infos WHERE email = '$email'";
        }else {
            $db = Db::getInstance();
            $sql = "SELECT * FROM users_info WHERE username = '$email'";
        }
        $result = "";
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }
    /**
     * Check if user exists
     * @param $username
     * @return string
     */
    public static function isExistUser($username)
    {

        $result = [];
        try {

            $db = Db::getInstance();
            $sql = "SELECT * FROM users_info WHERE username = '$username'";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return !empty($result);
    }

    /**
     * Get user by Id
     * @param $id
     * @return string
     */
    public static function getUserById($id)
    {
        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM users WHERE id = $id";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Add new user
     * @param $data
     */
    public static function addUser($data)
    {
        try {
            $sql = "
                INSERT INTO `users` (
                    `username` ,
                    `password`
                )
                VALUES (
                    '" . $data['email'] . "' ,
                    '" . $data['pass'] . "'
                )
            ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Add regular user
     * @param $data
     */
    public static function addRegularUser($data)
    {
        try {
            $sql = "
                INSERT INTO `users_info` (
                    `username` ,
                    `full_name` ,
                    `company_name` ,
                    `phone` ,
                    `address` ,
                    `comments`
                )
                VALUES (
                    '" . $data['username'] . "' ,
                    '" . $data['name'] . "' ,
                    '" . $data['legalName'] . "' ,
                    '" . $data['phone'] . "' ,
                    '" . $data['address'] . "' ,
                    '" . $data['comments'] . "'
                )
            ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Add comment on vendor
     * @param $data
     */
    public static function addComments($data)
    {
        $date = date("y-m-d");
        try {
            $sql = "
                INSERT INTO `user_comments` (
                    `comment` ,
                    `stars` ,
                    `comment_date` ,
                    `vendor_id`
                )
                VALUES (
                    '" . $data['comment'] . "' ,
                    '" . $data['star'] . "' ,
                    '" . $date . "' ,
                    '" . $data['vendorId'] . "' 
                )
            ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Add to cart
     * @param $data
     */
    public static function addToCart($data)
    {
        try {
            $sql = "
                INSERT INTO `cart` (
                    `name` ,
                    `count` ,
                    `amount`,
                    `comment`
                    
                )
                VALUES (
                    '" . $data['name'] . "' ,
                    '" . $data['count'] . "' ,
                    '" . $data['amount'] . "' ,
                    '" . $data['comment'] . "' 
                )
            ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Add order
     * @param $data
     */
    public static function addOrder($data)
    {
        echo '<pre>';
        print_r($data);
        die();
        try {
            $sql = "
                INSERT INTO `cart` (
                    `name` ,
                    `count` ,
                    `amount`,
                    `comment`
                    
                )
                VALUES (
                    '" . $data['name'] . "' ,
                    '" . $data['count'] . "' ,
                    '" . $data['amount'] . "' ,
                    '" . $data['comment'] . "' 
                )
            ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Update regular user
     * @param $data
     */
    public static function updateRegularUser($data)
    {
        try {
          $sql = "UPDATE `users`       
                SET  `name` =  '" . $data['name'] . "'  ,
                    `phone` =  '" . $data['phone'] . "'  ,
                    `address`  =  '" . $data['address'] . "'  
                WHERE `id` =  '" . $data['id'] . "' ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }


    /**
     * Add type to user
     * @param $data
     */
    public static function addType($data)
    {
        $id = $data['id'];
        $type = $data['type'];
        try {
            $sql = "UPDATE `users`       
                SET `user_type`=   '" . $type . "'
                WHERE `id` = $id";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Delete user
     * @param $id
     */
    public static function deleteUser($id)
    {
        try {
            $sql = "DELETE FROM users_info 
                         WHERE `id` = $id";
            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Delete user
     */
    public static function deleteCartInfo()
    {
        try {
            $sql = "DELETE * FROM cart";
            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Get all news
     * @return string
     */
    public static function getAllNews()
    {
        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM news";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }
    /**
     * Set User session
     * @param $data
     */
    public static function _setUserSession($data)
    {
        $_SESSION["email"] = $data;
        $_SESSION["logged_in"] = true;
    }
}