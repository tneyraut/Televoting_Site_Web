<?php

Groupe::addQuery('AJOUTER_GROUPE', 'INSERT INTO groupe(groupe_name) VALUES (:groupe_name)');

Groupe::addQuery('MISE_A_JOUR_GROUPE', 'UPDATE groupe SET groupe_name=:groupe_name WHERE groupe_id=:groupe_id');

Groupe::addQuery('GROUPE_BY_ID', 'SELECT groupe_id,groupe_name FROM groupe WHERE groupe_id=:groupe_id');

Groupe::addQuery('LISTE_GROUPES', 'SELECT groupe_id,groupe_name FROM groupe ORDER BY groupe_name');

Groupe::addQuery('SUPPIMER_GROUPE', 'DELETE FROM groupe WHERE groupe_id=:groupe_id');

Groupe::addQuery('SUPPIMER_GROUPE_BY_NAME', 'DELETE FROM groupe WHERE groupe_name=:groupe_name');

Groupe::addQuery('GROUPE_BY_NAME', 'SELECT groupe_id,groupe_name FROM groupe WHERE groupe_name=:groupe_name');

Groupe::addQuery('GROUPE_EXIST', 'SELECT COUNT(groupe_id) AS resultat FROM groupe WHERE groupe_name=:groupe_name');
