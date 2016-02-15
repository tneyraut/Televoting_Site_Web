<?php

class User extends Model
{

    public static function isLoginUsed($login)
    {
        return count(parent::exec('IS_LOGIN_USED', array(':login' => $login))) != 0;
    }
    
    public static function getByID($id) {
        $users = parent::exec('USER_BY_ID', array(':id' => $id));

        $user = NULL;
        if (count($users) > 0) {
            $user = $users[0];
        }

        return $user;
    }

    public static function tryLogin($login, $pwd)
    {
        $users = parent::exec('USER_CONNECT', array(':login' => $login));

        if(count($users) > 0)
        {
            $user = $users[0];
            
            if($user->password !== sha1($pwd))
                return NULL;
            else
            {
                $session = Session::singleton();
                $session->userId = $user->user_id;
                return $user;
            }
        }

        return NULL;
    }
    
    public static function getUsers()
    {
        return parent::exec('USERS', array());
    }
    
    public static function ajouterUser($login,$password,$admin,$professeur,$annee,$promotion, $groupe_id)
    {
        if ($admin == "Oui") {
            $admin = 1;
        }
        else {
            $admin = 0;
        }
        if ($professeur == "professeur") {
            $professeur = 1;
        }
        else {
            $professeur = 0;
        }
        if ($professeur == 1) {
            parent::exec('AJOUTER_PROFESSEUR', array(
                ':login' => $login,
                ':password' => $password,
                ':admin' => $admin,
                ':professeur' => $professeur
            ));
        }
        else {
            parent::exec('AJOUTER_USER', array(
                ':login' => $login,
                ':password' => $password,
                ':admin' => $admin,
                ':professeur' => $professeur,
                ':annee' => $annee,
                ':promotion' => $promotion
            ));
            $user = User::getUserByLogin($login);
            User_Groupe::ajouterUserGroupe($user->user_id, $groupe_id);
        }
    }
    
    public static function supprimerUser($login)
    {
        parent::exec('SUPPRIMER_USER', array(':login' => $login));
    }
    
    public static function getUserByLogin($login)
    {
        $users = parent::exec('USER_BY_LOGIN', array(':login' => $login));
        if (count($users) > 0) {
            return $users[0];
        }
        return NULL;
    }
    
    public static function getProfesseurs() 
    {
        return parent::exec('USERS_PROFESSEUR', array());
    }
    
    public static function supprimerPromotion($promotion)
    {
        parent::exec('SUPPRIMER_PROMOTION', array(':promotion' => $promotion));
    }
    
    public static function modifierAnneeByPromotion($annee, $promotion)
    {
        parent::exec('MODIFIER_ANNEE_BY_PROMOTION', array(':annee' => $annee, ':promotion' => $promotion));
    }
    
    public static function promotionExiste($promotion)
    {
        return count(parent::exec('PROMOTION_EXISTE', array(':promotion' => $promotion))) != 0;
    }
    
    public static function getUsersByAnnee($annee)
    {
        return parent::exec('USERS_BY_ANNEE', array(':annee' => $annee));
    }
    
    public static function getProfesseurByQuestionnaire($questionnaire_id)
    {
        $resultat = parent::exec('PROFESSEUR_BY_QUESTIONNAIRE', array(':questionnaire_id' => $questionnaire_id));
        if (count($resultat) > 0) {
            return $resultat[0];
        }
        return NULL;
    }
    
    public static function getUsersByPromotion($promotion)
    {
        return parent::exec('USERS_BY_PROMOTION', array(':promotion' => $promotion));
    }
    
    public static function getUsersByGroupeId($groupe_id)
    {
        return parent::exec('USERS_BY_GROUPE_ID', array(':groupe_id' => $groupe_id));
    }
    
    public static function getProfesseurByCours($cours_id)
    {
        $resultat = parent::exec('PROFESSEUR_BY_COURS', array(':cours_id' => $cours_id));
        if (count($resultat) > 0) {
            return $resultat[0];
        }
        return NULL;
    }
    
    public static function miseAJourUser($user_id, $password, $professeur, $annee, $admin, $promotion, $groupe_id)
    {
        User_Groupe::ajouterUserGroupe($user_id, $groupe_id);
        parent::exec('MISE_A_JOUR_USER', array(
            ':user_id' => $user_id,
            ':password' => $password,
            ':professeur' => $professeur,
            ':annee' => $annee,
            ':admin' => $admin,
            ':promotion' => $promotion
        ));
    }
    
    public static function getAllEleves()
    {
        return parent::exec('ALL_ELEVES', array());
    }
    
}