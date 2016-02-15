<?php

Participant::addQuery('AJOUTER_PARTICIPANT', 
        'INSERT INTO participant(user_id,questionnaire_id,nombre_de_fautes,nombre_de_bonnes_reponses,note) 
        VALUES (:user_id,:questionnaire_id,:nombre_de_fautes,:nombre_de_bonnes_reponses,:note)');

Participant::addQuery('PARTICIPANT_BY_QUESTIONNAIRE_AND_USER', 
        'SELECT participant_id,user_id,questionnaire_id,nombre_de_fautes,nombre_de_bonnes_reponses,note 
        FROM participant 
        WHERE questionnaire_id=:questionnaire_id 
        AND user_id=:user_id');

Participant::addQuery('SUPPRIMER_PARTICIPANTS_BY_USER', 'DELETE FROM participant WHERE user_id=:user_id');

Participant::addQuery('SUPPRIMER_PARTICIPANTS_BY_QUESTIONNAIRE', 'DELETE FROM participant WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_LOGIN', 
        'SELECT participant.participant_id,participant.user_id,participant.questionnaire_id,participant.nombre_de_fautes,participant.nombre_de_bonnes_reponses,participant.note,user.login,user.promotion,user.annee 
        FROM participant,user 
        WHERE participant.questionnaire_id=:questionnaire_id 
        AND participant.user_id=user.user_id 
        ORDER BY user.login');

Participant::addQuery('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_NOMBRE_FAUTES', 
        'SELECT participant_id,participant.user_id,questionnaire_id,nombre_de_fautes,nombre_de_bonnes_reponses,note,user.login,user.promotion,user.annee 
        FROM participant,user 
        WHERE questionnaire_id=:questionnaire_id 
        AND participant.user_id=user.user_id 
        ORDER BY nombre_de_fautes');

Participant::addQuery('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_NOMBRE_BONNES_REPONSES', 
        'SELECT participant_id,participant.user_id,questionnaire_id,nombre_de_fautes,nombre_de_bonnes_reponses,note,user.login,user.promotion,user.annee 
        FROM participant,user 
        WHERE questionnaire_id=:questionnaire_id 
        AND participant.user_id=user.user_id 
        ORDER BY nombre_de_bonnes_reponses');

Participant::addQuery('PARTICIPANT_BY_QUESTIONNAIRE_ORDER_BY_NOTE', 
        'SELECT participant_id,participant.user_id,questionnaire_id,nombre_de_fautes,nombre_de_bonnes_reponses,note,user.login,user.promotion,user.annee 
        FROM participant,user 
        WHERE questionnaire_id=:questionnaire_id 
        AND participant.user_id=user.user_id 
        ORDER BY note');

Participant::addQuery('NOMBRE_DE_PARTICIPANTS_BY_QUESTIONNAIRE', 
        'SELECT COUNT(participant_id) AS nombreDeParticipants 
        FROM participant 
        WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('MOYENNE_NOMBRE_DE_BONNES_REPONSES_BY_QUESTIONNAIRE', 
        'SELECT (SUM(nombre_de_bonnes_reponses) / IF(COUNT(participant_id)=0,1,COUNT(participant_id))) AS moyenneNombreBonnesReponses 
        FROM participant 
        WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('MOYENNE_NOMBRE_DE_FAUTES_BY_QUESTIONNAIRE', 
        'SELECT (SUM(nombre_de_fautes) / IF(COUNT(participant_id)=0,1,COUNT(participant_id))) AS moyenneNombreFautes 
        FROM participant 
        WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('MOYENNE_NOTE_BY_QUESTIONNAIRE', 
        'SELECT SUM(note) / IF(COUNT(participant_id)=0,1,COUNT(participant_id)) as moyenneNote 
        FROM participant 
        WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('NOTE_MAX_BY_QUESTIONNAIRE', 
        'SELECT MAX(note) AS maxNote FROM participant WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('NOTE_MIN_BY_QUESTIONNAIRE', 
        'SELECT MIN(note) AS minNote FROM participant WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('NOMBRE_BONNES_REPONSES_MAX_BY_QUESTIONNAIRE', 
        'SELECT MAX(nombre_de_bonnes_reponses) AS maxNombreBonnesReponses 
        FROM participant 
        WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('NOMBRE_BONNES_REPONSES_MIN_BY_QUESTIONNAIRE', 
        'SELECT MIN(nombre_de_bonnes_reponses) AS minNombreBonnesReponses 
        FROM participant 
        WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('NOMBRE_FAUTES_MAX_BY_QUESTIONNAIRE', 
        'SELECT MAX(nombre_de_fautes) AS maxNombreFautes FROM participant WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('NOMBRE_FAUTES_MIN_BY_QUESTIONNAIRE', 
        'SELECT MIN(nombre_de_fautes) AS minNombreFautes FROM participant WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('PARTICIPANT_BY_USER', 
        'SELECT participant_id,user_id,questionnaire_id FROM participant WHERE user_id=:user_id');

Participant::addQuery('MISE_A_JOUR_PARTICIPANT', 
        'UPDATE participant SET nombre_de_fautes=:nombre_de_fautes, nombre_de_bonnes_reponses=:nombre_de_bonnes_reponses, note=:note 
        WHERE participant_id=:participant_id');

Participant::addQuery('PARTICIPANTS_BY_QUESTIONNAIRE', 'SELECT participant_id FROM participant WHERE questionnaire_id=:questionnaire_id');

Participant::addQuery('REINITIALISATION_PARTICIPANTS_BY_QUESTIONNAIRE', 
        'UPDATE participant SET nombre_de_fautes=0, nombre_de_bonnes_reponses=0,note=0 
        WHERE questionnaire_id=:questionnaire_id');
