<?php

class Proposition_Reponse extends Model
{
    
    public static function ajouterPropositionReponse($participant_id, $question_id)
    {
        parent::exec('AJOUTER_PROPOSITION_REPONSE', array(
            ':participant_id' => $participant_id,
            ':question_id' => $question_id
        ));
    }
    
    public static function supprimerPropostionReponseByParticipant($participant_id)
    {
        parent::exec('SUPPRIMER_PROPOSITION_REPONSE_BY_PARTICIPANT', array(':participant_id' => $participant_id));
    }
    
    public static function supprimerPropositionReponseByQuestion($question_id)
    {
        parent::exec('SUPPRIMER_PROPOSITION_REPONSE_BY_QUESTION', array(':question_id' => $question_id));
    }
    
    public static function supprimerPropositionReponseByUser($user_id)
    {
        parent::exec('SUPPRIMER_PROPOSITION_REPONSE_BY_USER', array(':user_id' => $user_id));
    }
    
    public static function supprimerPropositionReponseByQuestionnaire($questionnaire_id)
    {
        parent::exec('SUPPRIMER_PROPOSITION_REPONSE_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
    }
    
    public static function getNombrePropositionReponseByParticipant($participant_id)
    {
        $resultat = parent::exec('NOMBRE_PROPOSITION_REPONSE_BY_PARTICIPANT', array(':participant_id' => $participant_id));
        if ($resultat != NULL) {
            return $resultat[0]->resultat;
        }
        return 0;
    }
    
    public static function miseAJourPropositionReponse($reponse_id, $question_id, $participant_id)
    {
        parent::exec('MISE_A_JOUR_PROPOSITION_REPONSE', array(
            ':reponse_id' => $reponse_id,
            ':question_id' => $question_id,
            ':participant_id' => $participant_id
        ));
    }
    
    public static function ajouterNouvellePropositionReponseComplete($participant_id, $question_id, $reponse_id) 
    {
        parent::exec('AJOUTER_NOUVELLE_PROPOSITION_REPONSE_COMPLETE', array(
            ':participant_id' => $participant_id,
            ':question_id' => $question_id,
            ':reponse_id' => $reponse_id
        ));
    }
    
    public static function getNombrePropositionReponseByQuestionAndParticipant($question_id, $participant_id) 
    {
        $resultat = parent::exec('NOMBRE_PROPOSITION_REPONSE_BY_QUESTION_AND_PARTICIPANT', array(':question_id' => $question_id, ':participant_id' => $participant_id));
        if ($resultat != NULL) {
            return $resultat[0]->resultat;
        }
        return 0;
    }
    
}