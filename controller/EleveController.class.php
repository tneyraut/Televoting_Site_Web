<?php

class EleveController extends Controller
{
    
    public function defaultAction() {
        //$cours = Cours::getCoursByAnnee($this->user->annee);
        $cours = Cours::getCoursByGroupeDuUser($this->user->user_id);
        $array = array();
        foreach ($cours as $unCours) {
            array_push($array, Cours::getNombreQuestionnaireAFaireByCours($unCours->cours_name, $this->user->user_id));
            array_push($array, Cours::getNombreQuestionnaireEnCoursByCours($unCours->cours_name, $this->user->user_id));
        }
        $this->view->render('eleve/choixCours', array('cours' => $cours, 'array' => $array));
        return new Response();
    }
    
    public function choixQuestionnaireAction()
    {
        $cours_name = $this->request->getPostValue("nomCours");
        $questionnaires = Questionnaire::getQuestionnaireLanceeByCours($cours_name);
        //$cours = Cours::getCoursByAnnee($this->user->annee);
        $cours = Cours::getCoursByGroupeDuUser($this->user->user_id);
        $array = array();
        foreach ($cours as $unCours) {
            array_push($array, Cours::getNombreQuestionnaireAFaireByCours($unCours->cours_name, $this->user->user_id));
            array_push($array, Cours::getNombreQuestionnaireEnCoursByCours($unCours->cours_name, $this->user->user_id));
        }
        $this->view->render('eleve/choixQuestionnaire', array(
            'cours_name' => $cours_name, 
            'questionnaires' => $questionnaires, 
            'cours' => $cours,
            'array' => $array
            ));
        return new Response();
    }
    
    public function choixQuestionAction($cours_name)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = $this->request->getPostValue('nomQuestionnaire');
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
        $questions = Question::getQuestionsNonReponduesByQuestionnaireAndParticipant($participant->participant_id, $questionnaire->questionnaire_id);
        
        if ($questionnaire->pause == 0) {
            $questionnaires = Questionnaire::getQuestionnaireByCours($cours_name);
            $this->view->render('eleve/salleAttente', array(
                'cours_name' => $cours_name,
                'questionnaire_name' => $questionnaire_name,
                'questions' => $questions,
                'questionnaires' => $questionnaires
            ));
        }
        else {
            $questionnaires = Questionnaire::getQuestionnaireByCours($cours_name);
            $this->view->render('eleve/choixQuestion', array(
                'cours_name' => $cours_name, 
                'questionnaire_name' => $questionnaire_name,
                'questions' => $questions,
                'questionnaires' => $questionnaires
            ));
        }
        return new Response();
    }
    
    public function repondreAction($cours_name, $questionnaire_name)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        $question_id = $this->request->getPostValue('question_id');
        $question = Question::getQuestionById($question_id);
        $reponses = Reponse::getReponseByQuestionId($question_id);
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
        Proposition_Reponse::ajouterPropositionReponse($participant->participant_id, $question_id);
        $this->view->render('eleve/repondre', array(
            'cours_name' => $cours_name,
            'questionnaire_name' => $questionnaire_name,
            'question' => $question,
            'reponses' => $reponses
        ));
        return new Response();
    }
    
    public function resultatsAction()
    {
        //$cours = Cours::getCoursByAnnee($this->user->annee);
        $cours = Cours::getCoursByGroupeDuUser($this->user->user_id);
        $this->view->render('eleve/choixCoursResultat', array('cours' => $cours));
        return new Response();
    }
    
    public function choixQuestionnaireResultatAction()
    {
        $nomCours = $this->request->getPostValue('nomCours');
        //$cours = Cours::getCoursByAnnee($this->user->annee);
        $cours = Cours::getCoursByGroupeDuUser($this->user->user_id);
        $questionnaires = Questionnaire::getQuestionnairesByUserParticipant($nomCours, $this->user->user_id);
        $this->view->render('eleve/choixQuestionnaireResultat', array('cours_name' => $nomCours, 'questionnaires' => $questionnaires, 'cours' => $cours));
        return new Response();
    }
    
    public function resultatAction($cours_name)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        $nomQuestionnaire = $this->request->getPostValue('nomQuestionnaire');
        $questionnaire = Questionnaire::getQuestionnaireByName($nomQuestionnaire, $cours_name);
        $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
        
        $moyenneNombreBonnesReponses = Participant::getMoyenneNombreDeBonnesReponseByQuestionnaire($questionnaire->questionnaire_id);
        $moyenneNombreFautes = Participant::getMoyenneNombreDeFautesByQuestionnaire($questionnaire->questionnaire_id);
        $moyenneNote = Participant::getMoyenneNoteByQuestionnaire($questionnaire->questionnaire_id);
        $maxNote = Participant::getMaxNoteByQuestionnaire($questionnaire->questionnaire_id);
        $minNote = Participant::getMinNoteByQuestionnaire($questionnaire->questionnaire_id);
        $questionnaires = Questionnaire::getQuestionnairesByUserParticipant($cours_name, $this->user->user_id);
        $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
        $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
        
        $this->view->render('eleve/resultat', array(
            'cours_name' => $cours_name, 
            'nomQuestionnaire' => $nomQuestionnaire, 
            'participant' => $participant,
            'moyenneNombreBonnesReponses' => $moyenneNombreBonnesReponses,
            'moyenneNombreFautes' => $moyenneNombreFautes,
            'moyenneNote' => $moyenneNote,
            'maxNote' => $maxNote,
            'minNote' => $minNote,
            'questionnaires' => $questionnaires,
            'bareme' => $bareme,
            'baremeFautes' => $baremeFautes
            ));
        return new Response();
    }
    
    public function reponseValideeAction($cours_name, $questionnaire_name, $question_id)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
        $note = $participant->note;
        $nombre_de_fautes = $participant->nombre_de_fautes;
        $nombre_de_bonnes_reponses = $participant->nombre_de_bonnes_reponses;
        $nombreBonnesReponses = Question::getNombreBonnesReponsesByQuestion($question_id);
        $reponses = $this->request->getPostValue('reponse');
        $faux = false;
        if ($reponses == NULL) {
            if ($nombreBonnesReponses == 0) {
                $note++;
                $nombre_de_bonnes_reponses++;
            }
            else {
                $faux = true;
            }
            $nombre_de_fautes = $nombre_de_fautes + $nombreBonnesReponses;
        }
        else {
            for ($i=0;$i<count($reponses);$i++)
            {
                $reponse = Reponse::getReponseByReponseAndQuestion($reponses[$i], $question_id);
                if ($i == 0) {
                    Proposition_Reponse::miseAJourPropositionReponse($reponse->reponse_id, $question_id, $participant->participant_id);
                }
                else {
                    Proposition_Reponse::ajouterNouvellePropositionReponseComplete($participant->participant_id, $question_id, $reponse->reponse_id);
                }
                if ($reponse->reponse_correcte == 1) {
                    $nombre_de_bonnes_reponses++;
                    $note++;
                }
                else {
                    $nombre_de_fautes++;
                    $faux = true;
                }
            }
            $lesReponsesCorrectes = Reponse::getReponsesCorrectesByQuestion($question_id);
            foreach ($lesReponsesCorrectes as $reponseCorrecte) {
                $ok = false;
                for ($i=0;$i<count($reponses);$i++) {
                    $reponse = Reponse::getReponseByReponseAndQuestion($reponses[$i], $question_id);
                    if ($reponseCorrecte->reponse_id == $reponse->reponse_id) {
                        $ok = true;
                        break;
                    }
                }
                if (!$ok) {
                    $nombre_de_fautes++;
                    $faux = true;
                }
            }
        }
        $note = $note - $questionnaire->malus * $nombre_de_fautes;
        if ($note < 0) {
            $note = 0;
        }
        Participant::MiseAJourParticipant($nombre_de_fautes, $nombre_de_bonnes_reponses, $note, $participant->participant_id);
        $questions = Question::getQuestionsNonReponduesByQuestionnaireAndParticipant($participant->participant_id, $questionnaire->questionnaire_id);
        $questionnaires = Questionnaire::getQuestionnairesByUserParticipant($cours_name, $this->user->user_id);
        
        if (count($questions) != 0) {
            if ($questionnaire->mode_examen == 0) {
                if ($faux) {
                    $reponsesCorrectes = Reponse::getReponsesCorrectesByQuestion($question_id);
                    $erreur = "Faux, la ou les bonnes réponses étaient les suivantes : ";
                    foreach ($reponsesCorrectes as $uneReponse) {
                        $erreur = $erreur.$uneReponse->reponse." / ";
                    }
                    $this->view->render('eleve/choixQuestion', array(
                        'cours_name' => $cours_name, 
                        'questionnaire_name' => $questionnaire_name,
                        'questions' => $questions,
                        'questionnaires' => $questionnaires,
                        'erreur' => $erreur
                    ));
                    return new Response();
                }
                else {
                    $this->view->render('eleve/choixQuestion', array(
                        'cours_name' => $cours_name, 
                        'questionnaire_name' => $questionnaire_name,
                        'questions' => $questions,
                        'questionnaires' => $questionnaires,
                        'success' => "Bravo, vous avez coché la ou les bonnes réponses."
                    ));
                    return new Response();
                }
            }

            $this->view->render('eleve/choixQuestion', array(
                'cours_name' => $cours_name, 
                'questionnaire_name' => $questionnaire_name,
                'questions' => $questions,
                'questionnaires' => $questionnaires
            ));
        }
        
        else {
            $questionnaires = Questionnaire::getQuestionnaireByCours($cours_name);
            $moyenneNombreBonnesReponses = Participant::getMoyenneNombreDeBonnesReponseByQuestionnaire($questionnaire->questionnaire_id);
            $moyenneNombreFautes = Participant::getMoyenneNombreDeFautesByQuestionnaire($questionnaire->questionnaire_id);
            $moyenneNote = Participant::getMoyenneNoteByQuestionnaire($questionnaire->questionnaire_id);
            $maxNote = Participant::getMaxNoteByQuestionnaire($questionnaire->questionnaire_id);
            $minNote = Participant::getMinNoteByQuestionnaire($questionnaire->questionnaire_id);
            $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            
            $this->view->render('eleve/resultat', array(
                'cours_name' => $cours_name, 
                'nomQuestionnaire' => $questionnaire_name, 
                'participant' => $participant,
                'moyenneNombreBonnesReponses' => $moyenneNombreBonnesReponses,
                'moyenneNombreFautes' => $moyenneNombreFautes,
                'moyenneNote' => $moyenneNote,
                'maxNote' => $maxNote,
                'minNote' => $minNote,
                'questionnaires' => $questionnaires,
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
            ));
        }
        
        return new Response();
    }
    
    public function lancerQuestionnaireAction($cours_name, $questionnaire_name)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
        foreach ($questions as $uneQuestion) {
            Proposition_Reponse::ajouterPropositionReponse($participant->participant_id, $uneQuestion->question_id);
        }
        $reponses = Reponse::getReponseByQuestionId($questions[0]->question_id); 
        $this->view->render('eleve/repondreUnTrait', array(
            'cours_name' => $cours_name,
            'questionnaire_name' => $questionnaire_name,
            'question' => $questions[0],
            'compteur' => 0,
            'reponses' => $reponses
        ));
        return new Response();
    }
    
    public function resultatLancerQuestionnaireAction($cours_name, $questionnaire_name, $compteur, $question_id)
    {
        $response = new Response();
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $compteur++;
        $nombreQuestions = Question::getNombreQuestionsByQuestionnaire($questionnaire->questionnaire_id);
        
        $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
        $note = $participant->note;
        $nombre_de_fautes = $participant->nombre_de_fautes;
        $nombre_de_bonnes_reponses = $participant->nombre_de_bonnes_reponses;
        $nombreBonnesReponses = Question::getNombreBonnesReponsesByQuestion($question_id);
        $reponses = $this->request->getPostValue('reponse');
        $faux = false;
        if ($reponses == NULL) {
            if ($nombreBonnesReponses == 0) {
                $note++;
                $nombre_de_bonnes_reponses++;
            }
            else {
                $faux = true;
            }
            $nombre_de_fautes = $nombre_de_fautes + $nombreBonnesReponses;
        }
        else {
            $mauvaiseReponse = false;
            foreach($reponses as $valeur)
            {
                $reponse = Reponse::getReponseByReponseAndQuestion($valeur,$question_id);
                Proposition_Reponse::miseAJourPropositionReponse($reponse->reponse_id, $question_id, $participant->participant_id);
                if ($reponse->reponse_correcte == 1) {
                    $nombre_de_bonnes_reponses++;
                    $note++;
                }
                else {
                    $nombre_de_fautes++;
                    $mauvaiseReponse = true;
                    $faux = true;
                }
            }
            $lesReponsesCorrectes = Reponse::getReponsesCorrectesByQuestion($question_id);
            foreach ($lesReponsesCorrectes as $reponseCorrecte) {
                $ok = false;
                for ($i=0;$i<count($reponses);$i++) {
                    $reponse = Reponse::getReponseByReponseAndQuestion($reponses[$i], $question_id);
                    if ($reponseCorrecte->reponse_id == $reponse->reponse_id) {
                        $ok = true;
                        break;
                    }
                }
                if (!$ok) {
                    $nombre_de_fautes++;
                    $faux = true;
                }
            }
        }
        $note = $note - $questionnaire->malus * $nombre_de_fautes;
        if ($note < 0) {
            $note = 0;
        }
        Participant::MiseAJourParticipant($nombre_de_fautes, $nombre_de_bonnes_reponses, $note, $participant->participant_id);
        
        if ($compteur < $nombreQuestions) {
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $reponses = Reponse::getReponseByQuestionId($questions[$compteur]->question_id);
            if ($questionnaire->mode_examen == 0) {
                if ($faux) {
                    $reponsesCorrectes = Reponse::getReponsesCorrectesByQuestion($question_id);
                    $erreur = "Faux, la ou les bonnes réponses étaient les suivantes : ";
                    foreach ($reponsesCorrectes as $uneReponse) {
                        $erreur = $erreur.$uneReponse->reponse." / ";
                    }
                    $this->view->render('eleve/repondreUnTrait', array(
                        'cours_name' => $cours_name,
                        'questionnaire_name' => $questionnaire_name,
                        'question' => $questions[$compteur],
                        'compteur' => $compteur,
                        'reponses' => $reponses,
                        'erreur' => $erreur
                    ));
                }
                else {
                    $this->view->render('eleve/repondreUnTrait', array(
                        'cours_name' => $cours_name,
                        'questionnaire_name' => $questionnaire_name,
                        'question' => $questions[$compteur],
                        'compteur' => $compteur,
                        'reponses' => $reponses,
                        'success' => "Bravo, vous avez coché la ou les bonnes réponses."
                    ));
                }
            }

            $this->view->render('eleve/repondreUnTrait', array(
                'cours_name' => $cours_name,
                'questionnaire_name' => $questionnaire_name,
                'question' => $questions[$compteur],
                'compteur' => $compteur,
                'reponses' => $reponses
            ));
        }
        else {
            $questionnaires = Questionnaire::getQuestionnaireByCours($cours_name);
            $moyenneNombreBonnesReponses = Participant::getMoyenneNombreDeBonnesReponseByQuestionnaire($questionnaire->questionnaire_id);
            $moyenneNombreFautes = Participant::getMoyenneNombreDeFautesByQuestionnaire($questionnaire->questionnaire_id);
            $moyenneNote = Participant::getMoyenneNoteByQuestionnaire($questionnaire->questionnaire_id);
            $maxNote = Participant::getMaxNoteByQuestionnaire($questionnaire->questionnaire_id);
            $minNote = Participant::getMinNoteByQuestionnaire($questionnaire->questionnaire_id);
            $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $this->user->user_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            
            $this->view->render('eleve/resultat', array(
                'cours_name' => $cours_name, 
                'nomQuestionnaire' => $questionnaire_name, 
                'participant' => $participant,
                'moyenneNombreBonnesReponses' => $moyenneNombreBonnesReponses,
                'moyenneNombreFautes' => $moyenneNombreFautes,
                'moyenneNote' => $moyenneNote,
                'maxNote' => $maxNote,
                'minNote' => $minNote,
                'questionnaires' => $questionnaires,
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
            ));
        }
        return $response;
    }
    
}