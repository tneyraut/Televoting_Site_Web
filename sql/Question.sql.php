<?php

Question::addQuery('QUESTION_BY_QUESTIONNAIRE', 
        'SELECT question_id,question,temps_imparti,image FROM question WHERE questionnaire_id=:id ORDER BY question_id');

Question::addQuery('QUESTION_BY_NAME', 'SELECT question_id,question,temps_imparti,image
        FROM question,questionnaire,cours 
        WHERE question.questionnaire_id=questionnaire.questionnaire_id 
        AND questionnaire.cours_id=cours.cours_id 
        AND questionnaire.questionnaire_name=:questionnaire_name 
        AND cours.cours_name=:cours_name 
        AND question.question=:question');

Question::addQuery('QUESTION_BY_ID', 'SELECT question_id,question,temps_imparti,image FROM question WHERE question_id=:id');

Question::addQuery('MISE_A_JOUR_QUESTION', 
        'UPDATE question SET question=:question,temps_imparti=:temps_imparti,image=:image WHERE question_id=:id');

Question::addQuery('AJOUTER_QUESTION', 
        'INSERT INTO question(questionnaire_id,question,temps_imparti,image) VALUES (:questionnaire_id,:question,:temps_imparti,:image)');

Question::addQuery('SUPPRIMER_QUESTION_BY_ID', 'DELETE FROM question WHERE question_id=:id');

Question::addQuery('SUPPRIMER_QUESTIONS_BY_QUESTIONNAIRE', 'DELETE FROM question WHERE questionnaire_id=:id');

Question::addQuery('QUESTION_EXIST', 'SELECT question FROM question WHERE question=:question AND questionnaire_id=:id');

Question::addQuery('NOMBRE_QUESTIONS_BY_QUESTIONNAIRE', 
        'SELECT COUNT(question_id) AS resultat FROM question WHERE questionnaire_id=:questionnaire_id');

Question::addQuery('QUESTIONS_NON_REPONDUES_BY_QUESTIONNAIRE_AND_PARTICIPANT', 
        'SELECT question_id,question,temps_imparti,image 
        FROM question 
        WHERE questionnaire_id=:questionnaire_id 
        AND question_id NOT IN (SELECT question_id FROM proposition_reponse WHERE participant_id=:participant_id)');

Question::addQuery('NOMBRE_BONNES_REPONSES_BY_QUESTION', 
        'SELECT COUNT(reponse_id) AS resultat 
        FROM reponse 
        WHERE reponse_correcte=1 
        AND question_id=:question_id');

Question::addQuery('NOMBRE_FAUTES_PARTICIPANT_BY_QUESTION', 
        'SELECT COUNT(proposition_reponse.proposition_reponse_id) AS resultat 
        FROM proposition_reponse,reponse 
        WHERE proposition_reponse.question_id=:question_id 
        AND proposition_reponse.reponse_id=reponse.reponse_id 
        AND reponse.reponse_correcte=0');

Question::addQuery('NOMBRE_BONNES_REPONSES_PARTICIPANT_BY_QUESTION', 
        'SELECT COUNT(proposition_reponse.proposition_reponse_id) AS resultat 
        FROM proposition_reponse,reponse 
        WHERE proposition_reponse.question_id=:question_id 
        AND proposition_reponse.reponse_id=reponse.reponse_id 
        AND reponse.reponse_correcte=1');

Question::addQuery('NOMBRE_TYPES_REPONSES_BY_QUESTION', 
        'SELECT reponse.reponse,COUNT(proposition_reponse.proposition_reponse_id) AS resultat 
        FROM reponse,proposition_reponse 
        WHERE reponse.reponse_id=proposition_reponse.reponse_id 
        AND reponse.question_id=:question_id
        GROUP BY (reponse.reponse)'
        );

Question::addQuery('NOMBRE_REPONSES_SANS_REPONSE_BY_QUESTION', 
        'SELECT COUNT(proposition_reponse_id) AS resultat 
        FROM proposition_reponse 
        WHERE reponse_id="" AND question_id=:question_id');
