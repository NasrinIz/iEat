<?php
/**
 * Created by PhpStorm.
 * User: Beaver2
 * Date: 2018-06-14
 * Time: 11:31
 */

class AdminModel
{
    /**
     * Get all advertisements
     */
    public static function getAllAdvertisements()
    {
        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM advertisements";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Add news
     * @param $data
     */
    public static function addMenuItem($data)
    {
        try {
          echo  $sql = "
                INSERT INTO `menus` (
                    `name` ,
                    `content` ,
                    `calories` ,
                    `amount` 
                )
                VALUES (
                    '" . $data['name'] . "' ,
                    '" . $data['content'] . "' ,
                    '" . $data['calories'] . "' ,
                    '" . $data['amount'] . "' 
        
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
     * Add news
     * @param $data
     */
    public static function addAdvertisement($data)
    {
        try {
            $sql = "
                INSERT INTO `advertisements` (
                    `title` ,
                    `content` 
                )
                VALUES (
                    '" . $data['title'] . "' ,
                    '" . $data['content'] . "' 
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
     * Add picture
     * @param $id
     * @param $img
     * @param $type
     */
    public static function addPicture($id, $img, $type)
    {
        try {
            $sql = "UPDATE `$type`       
                SET `img` =  '" . $img . "' 
                WHERE `id` =  '" . $id . "' ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Add picture
     * @param $data
     * @param $storeId
     */
    public static function setOrderTime($data, $storeId)
    {
        try {
            $sql = "UPDATE `timings`       
                SET `order_time_from` =  '" . $data['order_time_from'] . "' ,
                `order_time_to` =  '" . $data['order_time_to'] . "' 
                WHERE `store_id` =  '" . $storeId . "' ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }


    /**
     * Get user by email
     * @param $storeId
     * @return string
     */
    public static function getOrderTime($storeId)
    {
        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM timings WHERE store_id = '$storeId'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Update Status
     * @param $id
     * @param $status
     */
    public static function changeStatus($id, $status)
    {
        try {
           $sql = "UPDATE `orders`       
                SET `status` =  '" . $status . "' 
                WHERE `order_id` =  '" . $id . "' ";

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
    public static function getLastInsertedMenuItem()
    {
        $result = [];
        try {

            $db = Db::getInstance();
            $sql = "SELECT * FROM menus ORDER BY `menus`.`id` DESC
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
     * Get last inserted
     * @return mixed
     */
    public static function getLastInsertedAd()
    {
        $result = [];
        try {

            $db = Db::getInstance();
            $sql = "SELECT * FROM advertisements ORDER BY `advertisements`.`id` DESC
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
     * Edit Ad
     * @param $data
     */
    public static function editAd($data)
    {
        try {
            $sql = "UPDATE `advertisements`       
                SET `title` =  '" . $data['title'] . "',
                    `content` =  '" . $data['content'] . "'
                WHERE `id` =  '" . $data['id'] . "' ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Edit menu
     * @param $data
     */
    public static function editMenuItem($data)
    {
        try {
            $sql = "UPDATE `menus`       
                SET `name` =  '" . $data['name'] . "',
                    `content` =  '" . $data['content'] . "',
                    `calories` =  '" . $data['calories'] . "',
                    `amount` =  '" . $data['amount'] . "'
                WHERE `id` =  '" . $data['id'] . "' ";

            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Get ad
     * @param $id
     * @return string
     */
    public static function getAdById($id)
    {
        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM advertisements WHERE id=$id";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }

    /**
     * Get Menu Item
     * @param $id
     * @return string
     */
    public static function getMenuItemById($id)
    {
        $result = "";
        try {
            $db = Db::getInstance();
            $sql = "SELECT * FROM menus WHERE id=$id";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $e->getMessage();
        }
        return $result;
    }


    /**
     * Delete Add
     * @param $id
     */
    public static function deleteAd($id)
    {
        try {
            $sql = "DELETE FROM advertisements
                         WHERE `id` = $id";
            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Delete menu item
     * @param $id
     */
    public static function deleteMenuItem($id)
    {
        try {
            $sql = "DELETE FROM menus
                         WHERE `id` = $id";
            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Delete order
     * @param $id
     */
    public static function deleteOrder($id)
    {
        try {
            $sql = "DELETE FROM orders
                         WHERE `order_id` = $id";
            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * Get all orders for customer
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
     * Get all orders for customer
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
}