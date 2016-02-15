<?php

Cours::addQuery('COURS_BY_USER', 
        'SELECT cours_id,cours_name,annee,groupe_id 
        FROM cours 
        WHERE user_id=:id 
        ORDER BY cours_name');

Cours::addQuery('COURS_BY_NAME', 
        'SELECT cours_id,cours_name,annee,groupe_id 
        FROM cours 
        WHERE cours_name=:cours_name');

Cours::addQuery('COURS', 'SELECT cours_id,cours_name,groupe_id FROM cours ORDER BY cours_name');

Cours::addQuery('COURS_BY_ID', 'SELECT cours_id,cours_name,groupe_id,annee FROM cours WHERE cours_id=:cours_id');

Cours::addQuery('NOM_COURS_EXIST', 'SELECT cours_name FROM cours WHERE cours_name=:nom');

Cours::addQuery('AJOUTER_COURS', 'INSERT INTO cours(user_id,cours_name,annee,groupe_id) VALUES (:user_id,:cours_name,:annee,:groupe_id)');

Cours::addQuery('SUPPRIMER_COURS_BY_ID', 'DELETE FROM cours WHERE cours_id=:id');

Cours::addQuery('SUPPRIMER_COURS_BY_USER', 'DELETE FROM cours WHERE user_id=:id');

Cours::addQuery('SUPPRIMER_COURS_BY_NAME', 'DELETE FROM cours WHERE cours_name=:nom');

Cours::addQuery('COURS_BY_ANNEE', 'SELECT cours_id,cours_name,annee,groupe_id FROM cours WHERE annee=:annee ORDER BY cours_name');

Cours::addQuery('COURS_BY_NAME_AND_USER', 
        'SELECT cours_id,cours_name,annee,groupe_id 
        FROM cours 
        WHERE user_id=:id 
        AND cours_name=:cours_name');

Cours::addQuery('NOMBRE_DE_PROFESSEURS_BY_COURS', 
        'SELECT COUNT(user_id) AS nombreDeProfesseurs 
        FROM cours 
        WHERE cours_name=:cours_name');

Cours::addQuery('MISE_A_JOUR_COURS_BY_ID', 
        'UPDATE cours
        SET cours_name=:cours_name, user_id=:user_id, annee=:annee, groupe_id=:groupe_id 
        WHERE cours_id=:cours_id');

Cours::addQuery('COURS_BY_GROUPE_DU_USER', 
        'SELECT cours.cours_id,cours.cours_name,cours.annee,cours.groupe_id 
        FROM cours,user_groupe 
        WHERE cours.groupe_id=user_groupe.groupe_id 
        AND user_groupe.user_id=:user_id 
        ORDER BY cours.cours_name');
