<?php

class Session extends Object
{
    
    private static $instance = NULL;

    private function __construct()
    {
        session_start();
    }

    public static function singleton()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    public function __get($prop)
    {
        return $_SESSION[$prop];
    }

    public function __set($prop, $val)
    {
        $_SESSION[$prop] = $val;
    }
    
    public function __isset($prop) {
        return isset($_SESSION[$prop]);
    }
    
    public function __unset($prop) {
        unset($_SESSION[$prop]);
    }

    public static function destroy() {
        self::$instance = NULL;
        session_destroy();
    }
}