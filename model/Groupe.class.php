<?php

class Groupe extends Model
{
    
    public static function ajouterGroupe($groupe_name)
    {
        parent::exec('AJOUTER_GROUPE', array(':groupe_name' => $groupe_name));
    }
    
    public static function miseAJourGroupe($groupe_id, $groupe_name)
    {
        parent::exec('MISE_A_JOUR_GROUPE', array(
            ':groupe_id' => $groupe_id,
            ':groupe_name' => $groupe_name
        ));
    }
    
    public static function getGroupeById($groupe_id)
    {
        $resultat = parent::exec('GROUPE_BY_ID', array(':groupe_id' => $groupe_id));
        if (count($resultat) > 0) {
            return $resultat[0];
        }
        return NULL;
    }
    
    public static function getListeGroupes()
    {
        return parent::exec('LISTE_GROUPES', array());
    }
    
    public static function supprimerGroupe($groupe_id) 
    {
        parent::exec('SUPPIMER_GROUPE', array(':groupe_id' => $groupe_id));
    }
    
    public static function supprimerGroupeByName($groupe_name)
    {
        parent::exec('SUPPIMER_GROUPE_BY_NAME', array(':groupe_name' => $groupe_name));
    }
    
    public static function getGroupeByName($groupe_name)
    {
        $resultat = parent::exec('GROUPE_BY_NAME', array(':groupe_name' => $groupe_name));
        if (count($resultat) > 0) {
            return $resultat[0];
        }
        return NULL;
    }
    
    public static function groupeExiste($groupe_name)
    {
        $resultat = parent::exec('GROUPE_EXIST', array(':groupe_name' => $groupe_name));
        return ($resultat[0]->resultat != 0);
    }
    
}