<?php

class Participant extends Model
{
    
    public static function ajouterParticipant($user_id, $questionnaire_id, $nombre_de_fautes, $nombre_de_bonnes_reponses, $note)
    {
        parent::exec('AJOUTER_PARTICIPANT', array(
            ':user_id' => $user_id, 
            ':questionnaire_id' => $questionnaire_id,
            ':nombre_de_fautes' => $nombre_de_fautes,
            ':nombre_de_bonnes_reponses' => $nombre_de_bonnes_reponses,
            ':note' => $note
            ));
    }
    
    public static function getParticipantByQuestionnaireAndUser($questionnaire_id, $user_id)
    {
        $participant = parent::exec('PARTICIPANT_BY_QUESTIONNAIRE_AND_USER', array(':questionnaire_id' => $questionnaire_id, ':user_id' => $user_id));
        if ($participant != NULL) {
            return $participant[0];
        }
        return NULL;
    }
    
    public static function supprimerParticipantsByUser($user_id)
    {
        parent::exec('SUPPRIMER_PARTICIPANTS_BY_USER', array(':user_id' => $user_id));
    }
    
    public static function supprimerParticipantsByQuestionnaire($questionnaire_id)
    {
        parent::exec('SUPPRIMER_PARTICIPANTS_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
    }
    
    public static function getParticipantByQuestionnaireOrderByLogin($questionnaire_id)
    {
        return parent::exec('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_LOGIN', array(':questionnaire_id' => $questionnaire_id));
    }
    
    public static function getParticipantByQuestionnaireOrderByNombreFautes($questionnaire_id)
    {
        return parent::exec('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_NOMBRE_FAUTES', array(':questionnaire_id' => $questionnaire_id));
    }
    
    public static function getParticipantByQuestionnaireOrderByNombreBonnesReponses($questionnaire_id)
    {
        return parent::exec('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_NOMBRE_BONNES_REPONSES', array(':questionnaire_id' => $questionnaire_id));
    }
    
    public static function getParticipantByQuestionnaireOrderByNote($questionnaire_id)
    {
        return parent::exec('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_NOTE', array(':questionnaire_id' => $questionnaire_id));
    }

        public static function getNombreDeParticipantsByQuestionnaire($questionnaire_id)
    {
        $nombreDeParticipants = parent::exec('NOMBRE_DE_PARTICIPANTS_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        return $nombreDeParticipants[0]->nombreDeParticipants;
    }
    
    public static function getMoyenneNombreDeBonnesReponseByQuestionnaire($questionnaire_id)
    {
        $moyenneNombreBonnesReponses = parent::exec('MOYENNE_NOMBRE_DE_BONNES_REPONSES_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($moyenneNombreBonnesReponses != NULL) {
            return $moyenneNombreBonnesReponses[0]->moyenneNombreBonnesReponses;
        }
        return 0;
    }
    
    public static function getMoyenneNombreDeFautesByQuestionnaire($questionnaire_id)
    {
        $moyenneNombreFautes = parent::exec('MOYENNE_NOMBRE_DE_FAUTES_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($moyenneNombreFautes != NULL) {
            return $moyenneNombreFautes[0]->moyenneNombreFautes;
        }
        return 0;
    }
    
    public static function getMoyenneNoteByQuestionnaire($questionnaire_id)
    {
        $moyenneNote = parent::exec('MOYENNE_NOTE_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($moyenneNote != NULL) {
            return $moyenneNote[0]->moyenneNote;
        }
        return 0;
    }
    
    public static function getMaxNoteByQuestionnaire($questionnaire_id)
    {
        $maxNote = parent::exec('NOTE_MAX_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($maxNote != NULL) {
            return $maxNote[0]->maxNote;
        }
        return 0;
    }
    
    public static function getMinNoteByQuestionnaire($questionnaire_id)
    {
        $minNote = parent::exec('NOTE_MIN_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($minNote != NULL) {
            return $minNote[0]->minNote;
        }
        return 0;
    }
    
    public static function getMaxNombreBonnesReponsesByQuestionnaire($questionnaire_id)
    {
        $maxNombreBonnesReponses = parent::exec('NOMBRE_BONNES_REPONSES_MAX_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($maxNombreBonnesReponses != NULL) {
            return $maxNombreBonnesReponses[0]->maxNombreBonnesReponses;
        }
        return 0;
    }
    
    public static function getMinNombreBonnesReponsesByQuestionnaire($questionnaire_id)
    {
        $minNombreBonnesReponses = parent::exec('NOMBRE_BONNES_REPONSES_MIN_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($minNombreBonnesReponses != NULL) {
            return $minNombreBonnesReponses[0]->minNombreBonnesReponses;
        }
        return 0;
    }
    
    public static function getMaxNombreFautesByQuestionnaire($questionnaire_id)
    {
        $maxNombreFautes = parent::exec('NOMBRE_FAUTES_MAX_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($maxNombreFautes != NULL) {
            return $maxNombreFautes[0]->maxNombreFautes;
        }
        return 0;
    }
    
    public static function getMinNombreFautesByQuestionnaire($questionnaire_id)
    {
        $minNombreFautes = parent::exec('NOMBRE_FAUTES_MIN_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if ($minNombreFautes != NULL) {
            return $minNombreFautes[0]->minNombreFautes;
        }
        return 0;
    }
    
    public static function getParticipantByUser($user_id)
    {
        return parent::exec('PARTICIPANT_BY_USER', array(':user_id' => $user_id));
    }
    
    public static function MiseAJourParticipant($nombre_de_fautes, $nombre_de_bonnes_reponses, $note, $participant_id)
    {
        parent::exec('MISE_A_JOUR_PARTICIPANT', array(
            ':nombre_de_fautes' => $nombre_de_fautes,
            ':nombre_de_bonnes_reponses' => $nombre_de_bonnes_reponses,
            ':note' => $note,
            ':participant_id' => $participant_id
        ));
    }
    
    public static function getParticipantsByQuestionnaire($questionnaire_id)
    {
        return parent::exec('PARTICIPANTS_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
    }
    
    public static function reinitialisationParticipantsByQuestionnaire($questionnaire_id)
    {
        parent::exec('REINITIALISATION_PARTICIPANTS_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
    }
    
}