<?php

class DatabasePDO extends Object
{

    private static $instance = NULL;
    private $pdo = NULL;

    private function __construct()
    {
        $this->pdo = new PDO('mysql:host=' . __DB_HOST__ . ';dbname=' . __DB_NAME__, __DB_USER__, __DB_PWD__, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    public static function singleton()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new DatabasePDO();
        }

        return self::$instance->pdo;
    }

}