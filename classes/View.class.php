<?php

class View extends Object
{

    protected $templateNames;
    protected $args;

    public function __construct(Controller $controller)
    {
        $this->templateNames = array();
        $this->templateNames['head'] = 'head';
        $this->templateNames['header'] = 'header';
        $this->templateNames['menu'] = 'menu';
        $this->templateNames['aside'] = 'aside';
        $this->templateNames['footer'] = 'footer';

        $this->args = array();
        $this->setArg('controller', $controller);
        
        $this->setArg('user', $controller->getCurrentUser());
    }

    public function setArg($key, $val)
    {
        $this->args[$key] = $val;
    }

    public function setTemplate($key, $val)
    {
        $this->templateNames[$key] = $val;
    }

    public function render($templateName, $args = array())
    {
        $this->templateNames['content'] = $templateName;

        $this->args = array_merge($this->args, $args); // Fusion avec priorité des les arguments de render() pour les clés redondantes.

        $this->loadTemplate($this->templateNames['head'], $this->args);
        $this->loadTemplate($this->templateNames['header'], $this->args);
        $this->loadTemplate($this->templateNames['menu'], $this->args);
        $this->loadTemplate($this->templateNames['content'], $this->args);
        $this->loadTemplate($this->templateNames['aside'], $this->args);
        $this->loadTemplate($this->templateNames['footer'], $this->args);
    }

    public function loadTemplate($name, $args = NULL)
    {
        $templateFileName = __ROOT_DIR__ . '/templates/' . $name . 'Template.php';

        if(is_readable($templateFileName))
        {
            if(isset($args))
            {
                foreach($args as $key => $value)
                    $$key = $value;
            }
            require_once($templateFileName);
        }
        else
        {
            throw new Exception('undefined template "' . $name . '"');
        }
    }

    // bu raccourcis de Request::buildUrl accessible dans la vue
    public function bu($controller = NULL, $action = NULL, $args = array())
    {
        return Request::buildUrl($controller, $action, $args);
    }

    public function includeTemplate($templateName)
    {
        $templateFileName = __ROOT_DIR__ . '/templates/' . $templateName . 'Template.php';

        if(is_readable($templateFileName))
        {

            foreach($this->args as $key => $value)
                $$key = $value;
            require($templateFileName);
        }
    }

}