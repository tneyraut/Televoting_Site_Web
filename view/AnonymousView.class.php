<?php

class AnonymousView extends View
{

    public function render($templateName, $args = array())
    {

        $this->templateNames['content'] = $templateName;

        $this->args = array_merge($this->args, $args); // Fusion avec priorité des les arguments de render() pour les clés redondantes.

        $this->loadTemplate($this->templateNames['head'], $this->args);
        $this->loadTemplate($this->templateNames['header'], $this->args);
        $this->loadTemplate($this->templateNames['menu'], $this->args);
        if(isset($this->templateNames['boutonJouer']))
            $this->loadTemplate('anonymous/boutonJouer', $this->args);
        
        $this->loadTemplate($this->templateNames['content'], $this->args);
        
        if($this->templateNames['aside'])
            $this->loadTemplate($this->templateNames['aside'], $this->args);
        $this->loadTemplate($this->templateNames['footer'], $this->args);
    }

}