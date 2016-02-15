<?php

Reponse::addQuery('REPONSE_BY_ID', 
        'SELECT reponse_id,reponse,reponse_correcte,question_id,image FROM reponse WHERE reponse_id=:id');

Reponse::addQuery('MISE_A_JOUR_REPONSE', 
        'UPDATE reponse SET reponse=:reponse,reponse_correcte=:reponse_correcte,image=:image WHERE reponse_id=:id');

Reponse::addQuery('AJOUTER_REPONSE', 
        'INSERT INTO reponse(question_id,reponse,reponse_correcte,image) VALUES (:question_id,:reponse,:reponse_correcte,:image)');

Reponse::addQuery('REPONSES_BY_QUESTION_ID', 
        'SELECT reponse_id,reponse,reponse_correcte,image FROM reponse WHERE question_id=:id ORDER BY reponse');

Reponse::addQuery('SUPPRIMER_REPONSE_BY_QUESTION', 'DELETE FROM reponse WHERE question_id=:id');

Reponse::addQuery('SUPPRIMER_REPONSE_BY_ID', 'DELETE FROM reponse WHERE reponse_id=:id');

Reponse::addQuery('REPONSE_EXIST', 'SELECT reponse FROM reponse WHERE reponse=:reponse AND question_id=:id');

Reponse::addQuery('REPONSE_BY_REPONSE_AND_QUESTION', 
        'SELECT reponse_id,reponse,reponse_correcte,question_id,image FROM reponse WHERE reponse=:reponse AND question_id=:question_id');

Reponse::addQuery('REPONSES_CORRECTES_BY_QUESTION', 'SELECT reponse_id,reponse FROM reponse WHERE reponse_correcte=1 AND question_id=:question_id');

Reponse::addQuery('REPONSES_BY_QUESTIONNAIRE', 
        'SELECT reponse.reponse_id,reponse.reponse, reponse.question_id, reponse.reponse_correcte 
        FROM reponse,question 
        WHERE reponse.question_id=question.question_id 
        AND question.questionnaire_id=:questionnaire_id 
        ORDER BY question_id,reponse_id');
