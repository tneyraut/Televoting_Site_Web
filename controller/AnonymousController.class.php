<?php

class AnonymousController extends Controller
{

    public function defaultAction()
    {
        if (isset($this->user)) {
            $nombreQuestionnairesAFaire = 0;
            $nombreQuestionnaireEnCours = 0;
            if ($this->user->professeur == 0 ) {
                $cours = Cours::getCoursByGroupeDuUser($this->user->user_id);
                foreach ($cours as $unCours) {
                    $nombreQuestionnairesAFaire = $nombreQuestionnairesAFaire + Cours::getNombreQuestionnaireAFaireByCours($unCours->cours_name, $this->user->user_id);
                    $nombreQuestionnaireEnCours = $nombreQuestionnaireEnCours + Cours::getNombreQuestionnaireEnCoursByCours($unCours->cours_name, $this->user->user_id);
                }
            }
            $this->view->render('anonymous/default', array(
                'nombreQuestionnairesAFaire' => $nombreQuestionnairesAFaire,
                'nombreQuestionnaireEnCours' => $nombreQuestionnaireEnCours
                ));
        }
        else {
            $this->view->render('anonymous/default');
        }
        return new Response();
    }

    public function loginAction()
    {
        $response = new Response();
        
        $this->view->setTemplate('aside', '');

        if(($login = $this->request->getPostValue('login')) && ($password = $this->request->getPostValue('password')))
        {
            $user = User::tryLogin($login, $password);
            
            if(isset($user)) {
                if ($user->professeur == 0) {
                    $cours = Cours::getCoursByGroupeDuUser($this->user->user_id);
                    foreach ($cours as $unCours) {
                        $questionnaires = Questionnaire::getQuestionnaireByCours($unCours->cours_name);
                        foreach ($questionnaires as $questionnaire) {
                            $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $user->user_id);
                            if ($participant == NULL) {
                                Participant::ajouterParticipant($user->user_id, $questionnaire->questionnaire_id, 0, 0, 0);
                            }
                        }
                    }
                }
                
                $response->redirect('anonymous', 'default');
                return $response;
            } else {
                $this->view->render('anonymous/login', array('error' => 'Identifiants incorrects.'));
                return $response;
            }
        }
        else
        {
            $this->view->render('anonymous/login');
            return $response;
        }
    }
    
}