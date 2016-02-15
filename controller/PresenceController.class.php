<?php

class PresenceController extends Controller
{
    
    public function defaultAction() 
    {
        $cours = Cours::getCoursByUser($this->user->user_id);
        
        $this->view->render('presence/listeCours', array('cours' => $cours));
        
        return new Response();
    }
    
    public function listeElevesAction()
    {
        $cours_name = $this->request->getPostValue("cours_name");
        
        $cours = Cours::getCoursByName($cours_name);
        
        $users = User::getUsersByGroupeId($cours->groupe_id);
        
        $this->view->render('presence/listeEleves', array(
            'cours' => $cours, 
            'users' => $users
        ));
        
        return new Response();
    }
    
    public function validationPresencesAction($cours_name)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        
        $day = $this->request->getPostValue("day");
        $month = $this->request->getPostValue("month");
        $year = $this->request->getPostValue("year");
        
        $date_value = $day . "/" . $month . "/" . $year;
        
        $cours = Cours::getCoursByName($cours_name);
        
        $users = User::getUsersByGroupeId($cours->groupe_id);
        
        foreach ($users as $user)
        {
            $etat = $this->request->getPostValue($user->user_id);
            if ($etat == "En retard")
            {
                Retard::ajouterRetard($user->user_id, $cours->cours_id, $date_value);
            }
            else if ($etat == "Absent")
            {
                Absence::ajouterAbsence($user->user_id, $cours->cours_id, $date_value);
            }
        }
        
        $this->view->render('anonymous/default');
        
        return new Response();
    }
    
}