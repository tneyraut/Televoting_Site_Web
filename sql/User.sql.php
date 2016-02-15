<?php

User::addQuery('IS_LOGIN_USED', 'SELECT login FROM user WHERE login=:login');

User::addQuery('USER_BY_ID', 'SELECT user_id,login,professeur,admin,annee,responsable_absence_retard FROM user WHERE user_id=:id');

User::addQuery('USER_CONNECT', 'SELECT user_id,login,admin,password,professeur,annee,responsable_absence_retard FROM user WHERE login=:login');

User::addQuery('USERS', 'SELECT user_id,login FROM user ORDER BY login');

User::addQuery('AJOUTER_USER', 
        'INSERT INTO user(login,password,admin,professeur,annee,promotion) 
        VALUES (:login,:password,:admin,:professeur,:annee,:promotion)');

User::addQuery('AJOUTER_PROFESSEUR', 
        'INSERT INTO user(login,password,admin,professeur) VALUES (:login,:password,:admin,:professeur)');

User::addQuery('SUPPRIMER_USER', 'DELETE FROM user WHERE login=:login');

User::addQuery('USER_BY_LOGIN', 'SELECT user_id,login FROM user WHERE login=:login');

User::addQuery('USERS_PROFESSEUR', 'SELECT user_id,login,professeur FROM user WHERE professeur=1 ORDER BY login');

User::addQuery('SUPPRIMER_PROMOTION', 'DELETE FROM user WHERE promotion=:promotion');

User::addQuery('MODIFIER_ANNEE_BY_PROMOTION', 'UPDATE user SET annee=:annee WHERE promotion=:promotion');

User::addQuery('PROMOTION_EXISTE', 'SELECT user_id FROM user WHERE promotion=:promotion');

User::addQuery('USERS_BY_ANNEE', 'SELECT user_id,login FROM user WHERE annee=:annee ORDER BY login');

User::addQuery('USERS_BY_PROMOTION', 'SELECT user_id,login FROM user WHERE promotion=:promotion ORDER BY login');

User::addQuery('PROFESSEUR_BY_QUESTIONNAIRE', 
        'SELECT user.user_id,user.login 
        FROM user,questionnaire,cours 
        WHERE cours.user_id=user.user_id
        AND questionnaire.cours_id=cours.cours_id
        AND questionnaire_id=:questionnaire_id');

User::addQuery('USERS_BY_GROUPE_ID', 
        'SELECT user.user_id,user.login 
        FROM user,user_groupe,groupe 
        WHERE user.user_id=user_groupe.user_id 
        AND user_groupe.groupe_id=groupe.groupe_id 
        AND groupe.groupe_id=:groupe_id');

User::addQuery('PROFESSEUR_BY_COURS', 
        'SELECT user.user_id,user.login 
        FROM user,cours 
        WHERE cours.user_id=user.user_id 
        AND cours.cours_id=:cours_id');

User::addQuery('MISE_A_JOUR_USER', 
        'UPDATE user 
        SET password=:password,professeur=:professeur,annee=:annee,admin=:admin,promotion=:promotion 
        WHERE user_id=:user_id');

User::addQuery('ALL_ELEVES', 
        'SELECT user_id,login,annee,promotion FROM user 
        WHERE professeur=0 AND responsable_absence_retard=0 AND admin=0');
