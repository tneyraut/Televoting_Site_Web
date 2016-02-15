<?php

class Questionnaire extends Model
{
    
    public static function ajouterQuestionnaire($cours_id,$questionnaire_name,$mode_examen,$malus,$pause)
    {
        if ($mode_examen == "Oui") {
            $mode_examen = 1;
        }
        else {
            $mode_examen = 0;
        }
        if ($pause == "Oui") {
            $pause = 1;
        }
        else {
            $pause = 0;
        }
        parent::exec('AJOUT_QUESTIONNAIRE', array(
            ':cours_id' => $cours_id,
            ':questionnaire_name' => $questionnaire_name,
            ':mode_examen' => $mode_examen,
            ':malus' => $malus,
            ':pause' => $pause
        ));
    }
    
    public static function supprimerQuestionnaireByID($id)
    {
        parent::exec('SUPPRESSION_QUESTIONNAIRE_BY_ID', array(':id' => $id));
    }
    
    public static function supprimerQuestionnairesByCours($id)
    {
        parent::exec('SUPPRESSION_QUESTIONNAIRES_BY_COURS', array(':id' => $id));
    }
    
    public static function getQuestionnaireByCours($nom)
    {
        $questionnaires = parent::exec('QUESTIONNAIRE_BY_COURS', array(':nom' => $nom));
        if (count($questionnaires) > 0) {
            return $questionnaires;
        }
        return NULL;
    }
    
    public static function getQuestionnaireByName($nomQuestionnaire, $nomCours)
    {
        $questionnaires = parent::exec('QUESTIONNAIRE_BY_NAME', array(':nomQuestionnaire' => $nomQuestionnaire, ':nomCours' => $nomCours));
        if (count($questionnaires) > 0) {
            return $questionnaires[0];
        }
        return NULL;
    }
    
    public static function getQuestionnairesByAnnee($annee) {
        return parent::exec('QUESTIONNAIRE_BY_ANNEE', array(':annee' => $annee));
    }
    
    public static function miseAJourQuestionnaire($nomQuestionnaire, $nouveauNom, $nouveauMode, $nouveauNomCours, $cours_name, $user_id, $malus, $pause, $lancee)
    {
        if ($nouveauMode == 'Oui') {
            $nouveauMode = 1;
        }
        else {
            $nouveauMode = 0;
        }
        if ($pause == 'Oui') {
            $pause = 1;
        }
        else {
            $pause = 0;
        }
        if ($lancee == 'Oui') {
            $lancee = 1;
        }
        else {
            $lancee = 0;
        }
        parent::exec('MISE_A_JOUR_QUESTIONNAIRE_MODE_EXAMEN_AND_MALUS_AND_PAUSE', array(
            ':nouveauMode' => $nouveauMode, 
            ':nom' => $nomQuestionnaire,
            ':cours_name' => $nouveauNomCours,
            ':malus' => $malus,
            ':pause' => $pause,
            ':lancee' => $lancee
            ));
        $existe = Questionnaire::nomQuestionnaireExist($nouveauNom, $nouveauNomCours);
        if ($nouveauNom != "" && $existe) {
            return true;
        }
        else if ($nouveauNom != "" && !$existe) {
            parent::exec('MISE_A_JOUR_QUESTIONNAIRE_NOM', array(
                ':nouveauNom' => $nouveauNom, 
                ':nom' => $nomQuestionnaire,
                ':cours_name' => $cours_name
                ));
        }
        return false;
    }
    
    public static function nomQuestionnaireExist($nomQuestionnaire, $cours_name)
    {
        return count(parent::exec('NOM_QUESTIONNAIRE_EXIST', array(':nomQuestionnaire' => $nomQuestionnaire, ':cours_name' => $cours_name))) != 0;
    }
    
    public static function getQuestionnairesByUserParticipant($cours_name, $user_id)
    {
        return parent::exec('QUESTIONNAIRES_BY_USER_PARTICIPANT', array(':cours_name' => $cours_name, ':user_id' => $user_id));
    }
    
    public static function getQuestionnaireLanceeByCours($nom)
    {
        return parent::exec('QUESTIONNAIRE_LANCEE_BY_COURS', array(':nom' => $nom));
    }
    
    public static function questionnaireDejaFait($questionnaire_id) {
        $questions = Question::getQuestionByQuestionnaire($questionnaire_id);
        $nombreQuestionsByQuestionnaire = Question::getNombreQuestionsByQuestionnaire($questionnaire_id);
        $nombreQuestionsRepondues = 0;
        foreach ($questions as $question) {
            if (Proposition_Reponse::getNombrePropositionReponseByQuestion($question->question_id) > 0) {
                $nombreQuestionsRepondues++;
            }
        }
        return ($nombreQuestionsByQuestionnaire == $nombreQuestionsRepondues);
    }
    
    public static function getBareme($questionnaire_id) {
        $resultat = 0;
        $questions = Question::getQuestionByQuestionnaire($questionnaire_id);
        foreach ($questions as $question) {
            $nombreBonnesReponses = Question::getNombreBonnesReponsesByQuestion($question->question_id);
            $resultat = $resultat + $nombreBonnesReponses;
            if ($nombreBonnesReponses == 0) {
                $resultat++;
            }
        }
        return $resultat;
    }
    
    public static function getBaremeFautes($questionnaire_id) {
        $resultat = 0;
        $questions = Question::getQuestionByQuestionnaire($questionnaire_id);
        foreach ($questions as $question) {
            $reponses = Reponse::getReponseByQuestionId($question->question_id);
            $resultat = $resultat + count($reponses);
        }
        return $resultat;
    }
    
}