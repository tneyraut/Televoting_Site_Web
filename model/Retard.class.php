<?php

class Retard extends Model
{
    
    public static function ajouterRetard($user_id, $cours_id, $date_value)
    {
        parent::exec('AJOUTER_RETARD', array(
            ':user_id' => $user_id, 
            ':cours_id' => $cours_id, 
            ':date_value' => $date_value
        ));
    }
    
    public static function miseAJourRetard($retard_id, $justifiee)
    {
        parent::exec('MISE_A_JOUR_RETARD', array(
            ':retard_id' => $retard_id, 
            ':justifiee' => $justifiee
        ));
    }
    
    public static function getRetardsByCours($cours_id)
    {
        return parent::exec('RETARDS_BY_COURS', array(
            ':cours_id' => $cours_id
        ));
    }
    
    public static function getRetardsByUser($user_id)
    {
        return parent::exec('RETARDS_BY_USER', array(
            ':user_id' => $user_id
        ));
    }
    
    public static function getRetardsNonJustifieesByCours($cours_id)
    {
        return parent::exec('RETARDS_NON_JUSTIFIEES_BY_COURS', array(
            ':cours_id' => $cours_id
        ));
    }
    
    public static function getRetardsJustifieesByCours($cours_id)
    {
        return parent::exec('RETARDS_JUSTIFIEES_BY_COURS', array(
            ':cours_id' => $cours_id
        ));
    }
    
    public static function getRetardsNonJustifieesByUser($user_id)
    {
        return parent::exec('RETARDS_NON_JUSTIFIEES_BY_USER', array(
            ':user_id' => $user_id
        ));
    }
    
    public static function getRetardsJustifieesByUser($user_id)
    {
        return parent::exec('RETARDS_JUSTIFIEES_BY_USER', array(
            ':user_id' => $user_id
        ));
    }
    
    public static function getRetardsNonJustifiees()
    {
        return parent::exec('RETARDS_NON_JUSTIFIEES', array());
    }
    
    public static function supprimerRetard($retard_id)
    {
        parent::exec('SUPPRIMER_RETARD', array(':retard_id' => $retard_id));
    }
    
}
