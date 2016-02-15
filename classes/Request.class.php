<?php

class Request extends Object
{

    private static $instance = NULL;
    private $params;
    private $method;

    private function __construct()
    {
        $params = $_SERVER['QUERY_STRING'];
        $this->params = explode('/', $params);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public static function getCurrentRequest()
    {
        if(is_null(self::$instance))
        {
            self::$instance = new Request();
        }

        return self::$instance;
    }

    public function getControllerName()
    {
        if(isset($this->params[0]) && $this->params[0])
        {
            return $this->params[0];
        }
        else
        {
            return 'anonymous';
        }
    }

    public function getActionName()
    {
        if(isset($this->params[1]) && $this->params[1])
        {
            return $this->params[1];
        }
        else
        {
            return 'default';
        }
    }
    
    public function getParams() {
        $params = $this->params;
        unset($params[0]);
        
        if(isset($params[1])) {
            unset($params[1]);
        }
        
        return array_values($params);
    }
    
    public function getPostValue($key) {
        if(isset($_POST[$key])) {
            return $_POST[$key];
        }
        else {
            return NULL;
        }
    }

    public function getMethod()
    {
        return $this->method;
    }

    public static function redirect($url)
    {
        header("Location: $url");
    }
    
    public static function buildUrl($controller = NULL, $action = NULL, $args = array())
    {
        $url = __BASE_URL__ . '/';

        if(!$controller) {
            return $url;
        }
        
        if(!$action) {
            return $url . $controller;
        }

        $url = $url . "$controller/$action";
        foreach($args as $arg)
        {
            $url .= "/$arg";
        }

        return $url;
    }
}