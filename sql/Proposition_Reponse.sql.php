<?php

Proposition_Reponse::addQuery('AJOUTER_PROPOSITION_REPONSE', 
        'INSERT INTO proposition_reponse(participant_id,question_id) VALUES (:participant_id,:question_id)');

Proposition_Reponse::addQuery('SUPPRIMER_PROPOSITION_REPONSE_BY_PARTICIPANT', 
        'DELETE FROM proposition_reponse WHERE participant_id=:participant_id');

Proposition_Reponse::addQuery('SUPPRIMER_PROPOSITION_REPONSE_BY_QUESTION', 
        'DELETE FROM proposition_reponse WHERE question_id=:question_id');

Proposition_Reponse::addQuery('SUPPRIMER_PROPOSITION_REPONSE_BY_USER', 
        'DELETE FROM proposition_reponse 
        WHERE participant_id IN (SELECT participant_id FROM participant WHERE user_id=:user_id)');

Proposition_Reponse::addQuery('SUPPRIMER_PROPOSITION_REPONSE_BY_QUESTIONNAIRE', 
        'DELETE FROM proposition_reponse 
        WHERE participant_id IN (SELECT participant_id FROM participant WHERE questionnaire_id=:questionnaire_id)');

Proposition_Reponse::addQuery('NOMBRE_PROPOSITION_REPONSE_BY_PARTICIPANT', 
        'SELECT COUNT(proposition_reponse_id) AS resultat FROM proposition_reponse WHERE participant_id=:participant_id');

Proposition_Reponse::addQuery('MISE_A_JOUR_PROPOSITION_REPONSE', 
        'UPDATE proposition_reponse SET reponse_id=:reponse_id 
        WHERE question_id=:question_id AND participant_id=:participant_id');

Proposition_Reponse::addQuery('AJOUTER_NOUVELLE_PROPOSITION_REPONSE_COMPLETE', 
        'INSERT INTO proposition_reponse(participant_id,question_id,reponse_id) 
        VALUES (:participant_id,:question_id,:reponse_id)');

Proposition_Reponse::addQuery('NOMBRE_PROPOSITION_REPONSE_BY_QUESTION_AND_PARTICIPANT', 
        'SELECT COUNT(proposition_reponse_id) AS resultat  
        FROM proposition_reponse 
        WHERE question_id=:question_id
        AND participant_id=:participant_id');
