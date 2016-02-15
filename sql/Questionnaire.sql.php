<?php

Questionnaire::addQuery('QUESTIONNAIRE_BY_COURS', 
        'SELECT questionnaire.questionnaire_id,questionnaire.questionnaire_name,questionnaire.malus,questionnaire.pause,questionnaire.lancee 
        FROM questionnaire,cours 
        WHERE questionnaire.cours_id = cours.cours_id 
        AND cours.cours_name=:nom
        ORDER BY questionnaire.questionnaire_name');

Questionnaire::addQuery('QUESTIONNAIRE_BY_NAME', 
        'SELECT questionnaire.questionnaire_id,cours.cours_name,questionnaire.questionnaire_name,questionnaire.mode_examen,questionnaire.malus,questionnaire.pause,questionnaire.lancee 
        FROM cours,questionnaire 
        WHERE cours.cours_id=questionnaire.cours_id 
        AND questionnaire.questionnaire_name=:nomQuestionnaire 
        AND cours.cours_name=:nomCours');

Questionnaire::addQuery('QUESTIONNAIRE_BY_ANNEE', 
        'SELECT questionnaire.questionnaire_id,questionnaire.questionnaire_name,questionnaire.malus,questionnaire.pause,questionnaire.lancee 
        FROM questionnaire,cours 
        WHERE questionnaire.cours_id = cours.cours_id 
        AND cours.annee=:annee
        ORDER BY questionnaire.questionnaire_name');

Questionnaire::addQuery('NOM_QUESTIONNAIRE_EXIST', 
        'SELECT questionnaire_name 
        FROM questionnaire 
        WHERE questionnaire_name=:nomQuestionnaire 
        AND cours_id IN (SELECT cours_id FROM cours WHERE cours_name=:cours_name)');

Questionnaire::addQuery('MISE_A_JOUR_QUESTIONNAIRE_NOM', 
        'UPDATE questionnaire SET questionnaire_name=:nouveauNom 
        WHERE questionnaire_name=:nom 
        AND cours_id IN (SELECT cours_id FROM cours WHERE cours_name=:cours_name)');

Questionnaire::addQuery('MISE_A_JOUR_QUESTIONNAIRE_COURS', 
        'UPDATE questionnaire SET cours_id=:cours_id 
        WHERE questionnaire_name=:questionnaire_name 
        AND cours_id IN (SELECT cours_id FROM cours WHERE cours_name=:cours_name)');

Questionnaire::addQuery('MISE_A_JOUR_QUESTIONNAIRE_MODE_EXAMEN_AND_MALUS_AND_PAUSE', 
        'UPDATE questionnaire SET mode_examen=:nouveauMode, malus=:malus, pause=:pause, lancee=:lancee 
        WHERE questionnaire_name=:nom 
        AND cours_id IN (SELECT cours_id FROM cours WHERE cours_name=:cours_name)');

Questionnaire::addQuery('AJOUT_QUESTIONNAIRE', 
        'INSERT INTO questionnaire(cours_id,questionnaire_name,mode_examen,malus,pause) VALUES(:cours_id,:questionnaire_name,:mode_examen,:malus,:pause)');

Questionnaire::addQuery('SUPPRESSION_QUESTIONNAIRE_BY_ID', 'DELETE FROM questionnaire WHERE questionnaire_id=:id');

Questionnaire::addQuery('SUPPRESSION_QUESTIONNAIRES_BY_COURS', 'DELETE FROM questionnaire WHERE cours_id=:id');

Questionnaire::addQuery('QUESTIONNAIRES_BY_USER_PARTICIPANT', 
        'SELECT questionnaire_id,questionnaire_name 
        FROM questionnaire 
        WHERE cours_id IN (SELECT cours_id FROM cours WHERE cours_name=:cours_name) 
        AND questionnaire_id IN (SELECT questionnaire_id FROM participant WHERE user_id=:user_id)');

Questionnaire::addQuery('QUESTIONNAIRE_LANCEE_BY_COURS', 
        'SELECT questionnaire.questionnaire_id,questionnaire.questionnaire_name,questionnaire.malus,questionnaire.pause,questionnaire.lancee 
        FROM questionnaire,cours 
        WHERE questionnaire.cours_id = cours.cours_id 
        AND cours.cours_name=:nom 
        AND questionnaire.lancee=1 
        ORDER BY questionnaire.questionnaire_name');
