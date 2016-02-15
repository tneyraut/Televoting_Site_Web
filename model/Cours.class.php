<?php

class Cours extends Model
{
    
    public static function getCours()
    {
        return parent::exec('COURS', array());
    }
    
    public static function getCoursByName($cours_name)
    {
        $cours = parent::exec('COURS_BY_NAME', array(':cours_name' => $cours_name));
        if (count($cours) > 0) {
            return $cours[0];
        }
        return NULL;
    }
    
    public static function getCoursByUser($id)
    {
        return parent::exec('COURS_BY_USER', array(':id' => $id));
    }
    
    public static function nomCoursExist($nom)
    {
        return count(parent::exec('NOM_COURS_EXIST', array(':nom' => $nom))) != 0;
    }
    
    public static function ajouterCours($user_id,$cours_name,$annee, $groupe_id)
    {
        parent::exec('AJOUTER_COURS', array(
            ':user_id' => $user_id,
            ':cours_name' => $cours_name,
            ':annee' => $annee,
            ':groupe_id' => $groupe_id
        ));
    }
    
    public static function supprimerCoursById($id)
    {
        parent::exec('SUPPRIMER_COURS_BY_ID', array(':id' => $id));
    }
    
    public static function supprimerCoursByUser($id)
    {
        parent::exec('SUPPRIMER_COURS_BY_USER', array(':id' => $id));
    }
    
    public static function supprimerCoursByName($nom)
    {
        parent::exec('SUPPRIMER_COURS_BY_NAME', array(':nom' => $nom));
    }
    
    public static function getCoursByAnnee($annee)
    {
        return parent::exec('COURS_BY_ANNEE', array(':annee' => $annee));
    }
    
    public static function getCoursByNameAndUser($id,$cours_name)
    {
        $cours = parent::exec('COURS_BY_NAME_AND_USER', array(
            ':id' => $id,
            ':cours_name' => $cours_name
        ));
        if (count($cours) > 0) {
            return $cours[0];
        }
        return $cours;
    }
    
    public static function getNombreDeProfesseursByCours($cours_name)
    {
        $resultat = Cours::exec('NOMBRE_DE_PROFESSEURS_BY_COURS', array(':cours_name' => $cours_name));
        if ($resultat != NULL) {
            return $resultat[0]->nombreDeProfesseurs;
        }
        return 0;
    }
    
    public static function getNombreQuestionnaireAFaireByCours($cours_name, $user_id)
    {
        $resultat = 0;
        $questionnaires = Questionnaire::getQuestionnaireLanceeByCours($cours_name);
        foreach ($questionnaires as $questionnaire) {
            $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $user_id);
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $nombreQuestionsByQuestionnaire = count($questions);
            $nombreQuestionsRepondues = 0;
            foreach ($questions as $question) {
                if (Proposition_Reponse::getNombrePropositionReponseByQuestionAndParticipant($question->question_id, $participant->participant_id) > 0) {
                    $nombreQuestionsRepondues++;
                }
            }
            if (intval($nombreQuestionsByQuestionnaire) != $nombreQuestionsRepondues) {
                $resultat++;
            }
        }
        return $resultat;
    }
    
    public static function getNombreQuestionnaireEnCoursByCours($cours_name, $user_id)
    {
        $resultat = 0;
        $questionnaires = Questionnaire::getQuestionnaireLanceeByCours($cours_name);
        foreach ($questionnaires as $questionnaire) {
            $participant = Participant::getParticipantByQuestionnaireAndUser($questionnaire->questionnaire_id, $user_id);
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $nombreQuestionsByQuestionnaire = Question::getNombreQuestionsByQuestionnaire($questionnaire->questionnaire_id);
            $nombreQuestionsRepondues = 0;
            foreach ($questions as $question) {
                if (Proposition_Reponse::getNombrePropositionReponseByQuestionAndParticipant($question->question_id, $participant->participant_id) > 0) {
                    $nombreQuestionsRepondues++;
                }
            }
            if (intval($nombreQuestionsByQuestionnaire) != $nombreQuestionsRepondues && $nombreQuestionsRepondues > 0) {
                $resultat++;
            }
        }
        return $resultat;
    }
    
    public static function miseAJourCoursById($cours_id, $cours_name, $user_id, $annee, $groupe_id) {
        parent::exec('MISE_A_JOUR_COURS_BY_ID', array(
            ':cours_id' => $cours_id,
            ':cours_name' => $cours_name,
            ':user_id' => $user_id,
            ':annee' => $annee,
            ':groupe_id' => $groupe_id
        ));
    }
    
    public static function getCoursByGroupeDuUser($user_id)
    {
        return parent::exec('COURS_BY_GROUPE_DU_USER', array(':user_id' => $user_id));
    }
    
    public static function getCoursById($cours_id)
    {
        $cours = parent::exec('COURS_BY_ID', array(':cours_id' => $cours_id));
        if (count($cours) > 0)
        {
            return $cours[0];
        }
        return NULL;
    }
    
}