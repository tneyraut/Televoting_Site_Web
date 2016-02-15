<?php

class UserController extends Controller
{

    public function defaultAction()
    {
        $this->view->render('anonymous/default');
        
        return new Response();
    }
    
    public function deconnecterAction() {
        $this->session->destroy();
        
        $response = new Response();
        $response->redirect('anonymous');
        
        return $response;
    }
    
}