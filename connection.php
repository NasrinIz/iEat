<?php

class Db
{
    private static $instance = NULL;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $DB_host = "localhost";
            $DB_user = "root";
            $DB_pass = "root";
            $DB_name = "iEat";
            self::$instance = new PDO(
                'mysql:host=' . $DB_host . ';dbname=' . $DB_name . '', $DB_user, $DB_pass, $pdo_options);
        }
        return self::$instance;
    }
}