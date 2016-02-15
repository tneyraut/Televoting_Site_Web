<?php

class Question extends Model
{
    
    public static function getQuestionByQuestionnaire($id)
    {
        return parent::exec('QUESTION_BY_QUESTIONNAIRE', array(':id' => $id));
    }
    
    public static function getQuestionByName($question,$questionnaire_name,$cours_name)
    {
        $questions = parent::exec('QUESTION_BY_NAME', array(
            ':questionnaire_name' => $questionnaire_name,
            ':cours_name' => $cours_name,
            ':question' => $question
        ));
        if (count($questions) > 0) {
            return $questions[0];
        }
        return NULL;
    }
    
    public static function getQuestionById($id)
    {
        $questions = parent::exec('QUESTION_BY_ID', array(':id' => $id));
        if (count($questions) > 0) {
            return $questions[0];
        }
        return NULL;
    }
    
    public static function miseAJourQuestion($id,$question,$temps_imparti,$image)
    {
        if ($image == "") {
            $image = NULL;
        }
        parent::exec('MISE_A_JOUR_QUESTION', array(
            ':id' => $id, 
            ':question' => $question, 
            ':temps_imparti' => $temps_imparti,
            ':image' => $image
        ));
    }
    
    public static function ajouterQuestion($questionnaire_id,$question,$temps_imparti,$image)
    {
        if ($image == "") {
            $image = NULL;
        }
        parent::exec('AJOUTER_QUESTION', array(
            ':questionnaire_id' => $questionnaire_id,
            ':question' => $question,
            ':temps_imparti' => $temps_imparti,
            ':image' => $image
        ));
    }
    
    public static function supprimerQuestionById($id)
    {
        $question = Question::getQuestionById($id);
        if ($question->image != NULL) {
            Image::supprimerImageQuestion($question->image);
        }
        parent::exec('SUPPRIMER_QUESTION_BY_ID', array(':id' => $id));
    }
    
    public static function supprimerQuestionsByQuestionnaire($id)
    {
        $questions = Question::getQuestionByQuestionnaire($id);
        foreach ($questions as $question) {
            if ($question->image != NULL) {
                Image::supprimerImageQuestion($question->image);
            }
        }
        parent::exec('SUPPRIMER_QUESTIONS_BY_QUESTIONNAIRE', array(':id' => $id));
    }
    
    public static function questionExiste($id,$question_contenu)
    {
        return count(parent::exec('QUESTION_EXIST', array(':id' => $id, ':question' => $question_contenu))) != 0;
    }
    
    public static function getNombreQuestionsByQuestionnaire($questionnaire_id)
    {
        $resultat = parent::exec('NOMBRE_QUESTIONS_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($resultat != NULL) {
            return $resultat[0]->resultat;
        }
        return 0;
    }
    
    public static function getQuestionsNonReponduesByQuestionnaireAndParticipant($participant_id, $questionnaire_id)
    {
        return parent::exec('QUESTIONS_NON_REPONDUES_BY_QUESTIONNAIRE_AND_PARTICIPANT', array(
            ':questionnaire_id' => $questionnaire_id,
            ':participant_id' => $participant_id
        ));
    }
    
    public static function getNombreBonnesReponsesByQuestion($question_id)
    {
        $resultat = parent::exec('NOMBRE_BONNES_REPONSES_BY_QUESTION', array(':question_id' => $question_id));
        if ($resultat != NULL) {
            return $resultat[0]->resultat;
        }
        return 0;
    }
    
    public static function getNombreFautesParticipantByQuestion($question_id)
    {
        $resultat = parent::exec('NOMBRE_FAUTES_PARTICIPANT_BY_QUESTION', array(':question_id' => $question_id));
        if ($resultat != NULL) {
            return $resultat[0]->resultat;
        }
        return 0;
    }
    
    public static function getNombreBonnesReponsesParticipantByQuestion($question_id)
    {
        $resultat = parent::exec('NOMBRE_BONNES_REPONSES_PARTICIPANT_BY_QUESTION', array(':question_id' => $question_id));
        if ($resultat != NULL) {
            return $resultat[0]->resultat;
        }
        return 0;
    }
    
    public static function getNombreTypesReponsesByQuestion($question_id)
    {
        return parent::exec('NOMBRE_TYPES_REPONSES_BY_QUESTION', array(':question_id' => $question_id));
    }
    
    public static function getNombreReponsesSansReponse($question_id) {
        $resultat = parent::exec('NOMBRE_REPONSES_SANS_REPONSE_BY_QUESTION', array(':question_id' => $question_id));
        if ($resultat != NULL) {
            return $resultat[0]->resultat;
        }
        return 0;
    }
    
    public static function getStatistiquesQuestionsByQuestionnaire($questionnaire_id) {
        $questions = Question::getQuestionByQuestionnaire($questionnaire_id);
        $resultat = array();
        foreach ($questions as $question) {
            $tab = array();
            array_push($tab, $question->question);
            $nombreParticipants = Participant::getNombreDeParticipantsByQuestionnaire($questionnaire_id);
            $nombreBonnesReponses = Question::getNombreBonnesReponsesParticipantByQuestion($question->question_id);
            array_push($tab, $nombreBonnesReponses);
            $pourcentage  = $nombreBonnesReponses/$nombreParticipants * 100;
            array_push($tab, $pourcentage);
            $nombreFautes = Question::getNombreFautesParticipantByQuestion($question->question_id);
            array_push($tab, $nombreFautes);
            $nombreReponsesSansReponse = Question::getNombreReponsesSansReponse($question->question_id);
            array_push($tab, $nombreReponsesSansReponse);
            array_push($resultat, $tab);
        }
        return $resultat;
    }
    
}