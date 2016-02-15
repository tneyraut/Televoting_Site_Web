<?php

class Absence extends Model
{
    
    public static function ajouterAbsence($user_id, $cours_id, $date_value)
    {
        parent::exec('AJOUTER_ABSENCE', array(
            ':user_id' => $user_id, 
            ':cours_id' => $cours_id, 
            ':date_value' => $date_value
        ));
    }
    
    public static function miseAJourAbsence($absence_id, $justifiee)
    {
        parent::exec('MISE_A_JOUR_ABSENCE', array(
            ':absence_id' => $absence_id, 
            ':justifiee' => $justifiee
        ));
    }
    
    public static function getAbsencesByCours($cours_id)
    {
        return parent::exec('ABSENCES_BY_COURS', array(
            ':cours_id' => $cours_id
        ));
    }
    
    public static function getAbsencesByUser($user_id)
    {
        return parent::exec('ABSENCES_BY_USER', array(
            ':user_id' => $user_id
        ));
    }
    
    public static function getAbsencesNonJustifieesByCours($cours_id)
    {
        return parent::exec('ABSENCES_NON_JUSTIFIEES_BY_COURS', array(
            ':cours_id' => $cours_id
        ));
    }
    
    public static function getAbsencesJustifieesByCours($cours_id)
    {
        return parent::exec('ABSENCES_JUSTIFIEES_BY_COURS', array(
            ':cours_id' => $cours_id
        ));
    }
    
    public static function getAbsencesNonJustifieesByUser($user_id)
    {
        return parent::exec('ABSENCES_NON_JUSTIFIEES_BY_USER', array(
            ':user_id' => $user_id
        ));
    }
    
    public static function getAbsencesJustifieesByUser($user_id)
    {
        return parent::exec('ABSENCES_JUSTIFIEES_BY_USER', array(
            ':user_id' => $user_id
        ));
    }
    
    public static function getAbsencesNonJustifiees()
    {
        return parent::exec('ABSENCES_NON_JUSTIFIEES', array());
    }
    
    public static function supprimerAbsence($absence_id)
    {
        parent::exec('SUPPRIMER_ABSENCE', array(':absence_id' => $absence_id));
    }
    
}
