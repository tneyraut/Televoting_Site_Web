<?php

class Response extends Object
{
    
    protected $isRedirected = false;


    public function send() {
        if(!$this->isRedirected) {
            $output = ob_get_clean();
            print $output;
        }
    }
    
    public function redirect($controller, $action = NULL, $params = array())
    {
        Request::redirect(Request::buildUrl($controller, $action, $params));
        $this->isRedirected = true;
    }
    
    public function ajax($data) {
        ob_get_clean();
        header('Content-Type: application/json; charset=utf-8');
        
        echo JsonParser::parseToJson($data);
    }
    
}