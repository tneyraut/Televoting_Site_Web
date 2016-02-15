<?php

Class User_Groupe extends Model
{
    
    public static function ajouterUserGroupe($user_id, $groupe_id)
    {
        if (!User_Groupe::userGroupeExist($user_id, $groupe_id)) {
            parent::exec('AJOUTER_USER_GROUPE', array(
                ':user_id' => $user_id,
                ':groupe_id' => $groupe_id
            ));
        }
    }
    
    public static function supprimerUserGroupeById($user_groupe_id)
    {
        parent::exec('SUPPRIMER_USER_GROUPE_BY_ID', array(':user_groupe_id' => $user_groupe_id));
    }
    
    public static function supprimerUserGroupeByUserId($user_id)
    {
        parent::exec('SUPPRIMER_USER_GROUPE_BY_USER_ID', array(':user_id' => $user_id));
    }
    
    public static function supprimerUserGroupeByGroupeId($groupe_id) 
    {
        parent::exec('SUPPRIMER_USER_GROUPE_BY_GROUPE_ID', array(':groupe_id' => $groupe_id));
    }
    
    public static function userGroupeExist($user_id, $groupe_id)
    {
        return parent::exec('USER_GROUPE_EXISTE', array(
            ':user_id' => $user_id,
            ':groupe_id' => $groupe_id
        ))[0]->resultat != 0;
    }
    
}