<?php

abstract class Controller extends Object
{
    protected $request;
    protected $session;
    protected $view;
    protected $user;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->session = Session::singleton();
        $this->user = NULL;
        
        if(isset($this->session->userId)) {
            $this->user = User::getById($this->session->userId);
        }
        
        $viewClassName = ucfirst($this->request->getControllerName()) . 'View';
        $viewPath = __ROOT_DIR__ . '/view/' . $viewClassName . '.class.php';
        if(!is_readable($viewPath)) {
            $viewClassName = 'View';
        }

        $this->view = new $viewClassName($this);
    }

    public abstract function defaultAction();

    public function execute()
    {
        ob_start();
        
        $methodName = $this->request->getActionName() . 'Action';
        $response = call_user_func_array(array($this, $methodName), $this->request->getParams());
        
        $response->send();
    }
    
    public function getCurrentUser() {
        return $this->user;
    }
}