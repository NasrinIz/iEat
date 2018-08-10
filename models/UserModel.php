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
            $sql = "SELECT * FROM users";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Get all orders for customer
     * @param $customerId
     * @return string
     */
    public static function getAllOrders($customerId)
    {

        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM orders WHERE customer_id = $customerId";
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
            $sql = "SELECT * FROM menus WHERE id = $id";
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
     * Check if user exists
     * @param $username
     * @return string
     */
    public static function isExistUser($username)
    {

        $result = [];
        try {

            $db = Db::getInstance();
            $sql = "SELECT * FROM users WHERE username = '$username'";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return !empty($result);
    }

    /**
     * Check if user exists
     * @param $orderId
     * @return string
     */
    public static function getOrderDetailByOrderId($orderId)
    {
        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM order_details WHERE order_id = '$orderId'";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $result;
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
     * Add to cart
     * @param $data
     */
    public static function addToCart($data)
    {
        try {
            $sql = "
                INSERT INTO `cart` (
                    `customer_name` ,
                    `phone` ,
                    `address` ,
                    `name` ,
                    `count` ,
                    `amount`,
                    `comment`
                    
                )
                VALUES (
                    '" . $data['customerName'] . "' ,
                    '" . $data['phone'] . "' ,
                    '" . $data['address'] . "' ,
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
        try {
            $sql = "
                INSERT INTO `orders` (
                    `customer_id` ,
                    `full_name` ,
                    `address`, 
                    `phone` ,
                    `total_price`,
                    `description`,
                    `order_date_time`
                    
                )
                VALUES (
                    '" . $data['customerId'] . "' ,
                    '" . $data['full_name'] . "' ,
                    '" . $data['address'] . "' ,
                    '" . $data['phone'] . "' ,  
                    '" . $data['total_price'] . "' ,
                    '" . $data['comment'] . "' ,
                    '" . $data['order_date_time'] . "' 
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
     * Get last inserted
     * @return mixed
     */
    public static function getLastInsertedOrder()
    {
        $result = [];
        try {

            $db = Db::getInstance();
            $sql = "SELECT * FROM orders ORDER BY `orders`.`order_id` DESC
            LIMIT 1 ";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $result;
    }

    /**
     * Add order
     * @param $data
     * @param $orderId
     */
    public static function addOrderDetail($data, $orderId)
    {
        try {
            $sql = "
                INSERT INTO `order_details` (
                    `name` ,
                    `count` ,
                    `amount`, 
                    `comment` ,
                    `order_id`
                    
                )
                VALUES (
                    '" . $data['name'] . "' ,
                    '" . $data['count'] . "' ,
                    '" . $data['amount'] . "' ,
                    '" . $data['comment'] . "' ,
                    '" . $orderId . "' 
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
     * Add info for user
     * @param $data
     */
    public static function completeProfile($data)
    {
        $id = $data['id'];
        try {
            $sql = "UPDATE `users`       
                SET `address`=   '" . $data['address'] . "',
                `phone`=   '" . $data['phone'] . "',
                `name`=   '" . $data['name'] . "'
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
            $sql = "DELETE FROM users 
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
            $sql = "DELETE FROM cart";
            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
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