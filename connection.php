<?php

class Db
{

    private static $instance = NULL;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

            if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) { // For Test on Localhost
                $DB_host = "localhost";
                $DB_user = "admin";
                $DB_pass = "123456";
                $DB_name = "iEat";


                self::$instance = new PDO(
                    'mysql:host=' . $DB_host . ';dbname=' . $DB_name . '', $DB_user, $DB_pass, $pdo_options);
            }
            return self::$instance;
        }
    }
}