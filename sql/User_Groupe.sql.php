<?php

User_Groupe::addQuery('AJOUTER_USER_GROUPE', 'INSERT INTO user_groupe(user_id,groupe_id) VALUES (:user_id,:groupe_id)');

User_Groupe::addQuery('SUPPRIMER_USER_GROUPE_BY_ID', 'DELETE FROM user_groupe WHERE user_groupe_id=:user_groupe_id');

User_Groupe::addQuery('SUPPRIMER_USER_GROUPE_BY_USER_ID', 'DELETE FROM user_groupe WHERE user_id=:user_id');

User_Groupe::addQuery('SUPPRIMER_USER_GROUPE_BY_GROUPE_ID', 'DELETE FROM user_groupe WHERE groupe_id=:groupe_id');

User_Groupe::addQuery('USER_GROUPE_EXISTE', 'SELECT COUNT(user_groupe_id) AS resultat FROM user_groupe WHERE user_id=:user_id AND groupe_id=:groupe_id');
