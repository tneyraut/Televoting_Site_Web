<?php

Retard::addQuery('AJOUTER_RETARD', 
        'INSERT INTO retard(user_id,cours_id,date_value) 
        VALUES (:user_id,:cours_id,:date_value)');

Retard::addQuery('MISE_A_JOUR_RETARD', 
        'UPDATE retard SET justifiee=:justifiee 
        WHERE retard_id=:retard_id');

Retard::addQuery('RETARDS_BY_COURS', 
        'SELECT retard.retard_id,retard.user_id,retard.date_value,retard.justifiee,user.login 
        FROM retard,user 
        WHERE retard.user_id=user.user_id 
        AND retard.cours_id=:cours_id 
        GROUP BY retard.retard_id');

Retard::addQuery('RETARDS_BY_USER', 
        'SELECT retard.retard_id,retard.cours_id,retard.date_value,retard.justifiee,cours.cours_name 
        FROM retard,cours 
        WHERE retard.cours_id=cours.cours_id 
        AND retard.user_id=:user_id 
        GROUP BY retard.retard_id');

Retard::addQuery('RETARDS_NON_JUSTIFIEES_BY_COURS', 
        'SELECT retard.retard_id,retard.user_id,retard.date_value,retard.justifiee,user.login 
        FROM retard,user 
        WHERE retard.user_id=user.user_id 
        AND retard.justifiee=0 
        AND retard.cours_id=:cours_id 
        GROUP BY retard.retard_id');

Retard::addQuery('RETARDS_JUSTIFIEES_BY_COURS', 
        'SELECT retard.retard_id,retard.user_id,retard.date_value,retard.justifiee,user.login 
        FROM retard,user 
        WHERE retard.user_id=user.user_id 
        AND retard.justifiee=1 
        AND retard.cours_id=:cours_id 
        GROUP BY retard.retard_id');

Retard::addQuery('RETARDS_NON_JUSTIFIEES_BY_USER', 
        'SELECT retard.retard_id,retard.cours_id,retard.date_value,retard.justifiee,cours.cours_name 
        FROM retard,cours 
        WHERE retard.cours_id=cours.cours_id 
        AND retard.justifiee=0 
        AND retard.user_id=:user_id 
        GROUP BY retard.retard_id');

Retard::addQuery('RETARDS_JUSTIFIEES_BY_USER', 
        'SELECT retard.retard_id,retard.cours_id,retard.date_value,retard.justifiee,cours.cours_name 
        FROM retard,cours 
        WHERE retard.cours_id=cours.cours_id 
        AND retard.justifiee=1 
        AND retard.user_id=:user_id 
        GROUP BY retard.retard_id');

Retard::addQuery('RETARDS_NON_JUSTIFIEES', 
        'SELECT retard.retard_id,retard.cours_id,retard.user_id,retard.date_value,retard.justifiee,cours.cours_name,user.login 
        FROM retard,cours,user 
        WHERE retard.cours_id=cours.cours_id 
        AND retard.user_id=user.user_id 
        AND retard.justifiee=0 
        GROUP BY retard.retard_id');

Retard::addQuery('SUPPRIMER_RETARD', 
        'DELETE FROM retard 
        WHERE retard_id=:retard_id');
