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
     * Get all news
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
     * Add news
     * @param $data
     */
    public static function addNews($data)
    {
        try {
            $sql = "
                INSERT INTO `news` (
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
     * Update Status
     * @param $id
     * @param $status
     */
    public static function changeStatus($id,$status)
    {
        try {
            $sql = "UPDATE `orders`       
                SET `status` =  '" . $status . "' 
                WHERE `id` =  '" . $id . "' ";

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
    public static function getLastInsertedNews()
    {
        $result = [];
        try {

            $db = Db::getInstance();
            $sql = "SELECT * FROM news ORDER BY `news`.`id` DESC
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
     * Delete news
     * @param $id
     */
    public static function deleteNews($id)
    {
        try {
            $sql = "DELETE FROM news 
                         WHERE `id` = $id";
            $db = Db::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
        }
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

}