<?php

class AdminPresenceController extends Controller 
{
    
    public function defaultAction()
    {
        $allRetardsNonJustifies = Retard::getRetardsNonJustifiees();
        
        $allAbsencesNonJustifiees = Absence::getAbsencesNonJustifiees();
        
        $eleves = User::getAllEleves();
        
        $cours = Cours::getCours();
        
        $this->view->render('adminPresence/menuAdminPresence', array(
            'allRetardsNonJustifies' => $allRetardsNonJustifies,
            'allAbsencesNonJustifiees' => $allAbsencesNonJustifiees,
            'eleves' => $eleves,
            'cours' => $cours
        ));
        
        return new Response();
    }
    
    public function justificationAbsenceAction($absence_id)
    {
        Absence::miseAJourAbsence($absence_id, 1);
        
        $response = new Response();
        
        $response->redirect('adminPresence');
        
        return $response;
    }
    
    public function justificationRetardAction($retard_id)
    {
        Retard::miseAJourRetard($retard_id, 1);
        
        $response = new Response();
        
        $response->redirect('adminPresence');
        
        return $response;
    }
    
    public function listeRetardsAbsencesEleveAction()
    {
        $eleve_name = $this->request->getPostValue('eleve_name');
        
        $eleve = User::getUserByLogin($eleve_name);
        
        $retards = Retard::getRetardsByUser($eleve->user_id);
        
        $absences = Absence::getAbsencesByUser($eleve->user_id);
        
        $this->view->render('adminPresence/retardsAbsencesEleveDetails', array(
            'retards' => $retards,
            'absences' => $absences,
            'eleve' => $eleve
        ));
        
        return new Response();
    }
    
    public function justificationAbsenceFromEleveDetailAction($absence_id, $eleve_id)
    {
        Absence::miseAJourAbsence($absence_id, 1);
        
        $eleve = User::getByID($eleve_id);
        
        $retards = Retard::getRetardsByUser($eleve_id);
        
        $absences = Absence::getAbsencesByUser($eleve_id);
        
        $this->view->render('adminPresence/retardsAbsencesEleveDetails', array(
            'retards' => $retards,
            'absences' => $absences,
            'eleve' => $eleve
        ));
        
        return new Response();
    }
    
    public function justificationRetardFromEleveDetailAction($retard_id, $eleve_id)
    {
        Retard::miseAJourRetard($retard_id, 1);
        
        $eleve = User::getByID($eleve_id);
        
        $retards = Retard::getRetardsByUser($eleve_id);
        
        $absences = Absence::getAbsencesByUser($eleve_id);
        
        $this->view->render('adminPresence/retardsAbsencesEleveDetails', array(
            'retards' => $retards,
            'absences' => $absences,
            'eleve' => $eleve
        ));
        
        return new Response();
    }
    
    public function listeRetardsAbsencesCoursAction()
    {
        $cours_name = $this->request->getPostValue('cours_name');
        
        $cours = Cours::getCoursByName($cours_name);
        
        $retards = Retard::getRetardsByCours($cours->cours_id);
        
        $absences = Absence::getAbsencesByCours($cours->cours_id);
        
        $this->view->render('adminPresence/retardsAbsencesCoursDetails', array(
            'retards' => $retards,
            'absences' => $absences,
            'cours' => $cours
        ));
        
        return new Response();
    }
    
    public function justificationAbsenceFromCoursDetailAction($absence_id, $cours_id)
    {
        Absence::miseAJourAbsence($absence_id, 1);
        
        $cours = Cours::getCoursById($cours_id);
        
        $retards = Retard::getRetardsByCours($cours_id);
        
        $absences = Absence::getAbsencesByCours($cours_id);
        
        $this->view->render('adminPresence/retardsAbsencesCoursDetails', array(
            'retards' => $retards,
            'absences' => $absences,
            'cours' => $cours
        ));
        
        return new Response();
    }
    
    public function justificationRetardFromCoursDetailAction($retard_id, $cours_id)
    {
        Retard::miseAJourRetard($retard_id, 1);
        
        $cours = Cours::getCoursById($cours_id);
        
        $retards = Retard::getRetardsByCours($cours_id);
        
        $absences = Absence::getAbsencesByCours($cours_id);
        
        $this->view->render('adminPresence/retardsAbsencesCoursDetails', array(
            'retards' => $retards,
            'absences' => $absences,
            'cours' => $cours
        ));
        
        return new Response();
    }
    
}