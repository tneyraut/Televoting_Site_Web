<?php

Absence::addQuery('AJOUTER_ABSENCE', 
        'INSERT INTO absence(user_id,cours_id,date_value) 
        VALUES (:user_id,:cours_id,:date_value)');

Absence::addQuery('MISE_A_JOUR_ABSENCE', 
        'UPDATE absence SET justifiee=:justifiee 
        WHERE absence_id=:absence_id');

Absence::addQuery('ABSENCES_BY_COURS', 
        'SELECT absence.absence_id,absence.user_id,absence.date_value,absence.justifiee,user.login 
        FROM absence,user 
        WHERE absence.user_id=user.user_id 
        AND absence.cours_id=:cours_id 
        GROUP BY absence.absence_id');

Absence::addQuery('ABSENCES_BY_USER', 
        'SELECT absence.absence_id,absence.cours_id,absence.date_value,absence.justifiee,cours.cours_name 
        FROM absence,cours 
        WHERE absence.cours_id=cours.cours_id 
        AND absence.user_id=:user_id 
        GROUP BY absence.absence_id');

Absence::addQuery('ABSENCES_NON_JUSTIFIEES_BY_COURS', 
        'SELECT absence.absence_id,absence.user_id,absence.date_value,absence.justifiee,user.login 
        FROM absence,user 
        WHERE absence.user_id=user.user_id 
        AND absence.justifiee=0 
        AND absence.cours_id=:cours_id 
        GROUP BY absence.absence_id');

Absence::addQuery('ABSENCES_JUSTIFIEES_BY_COURS', 
        'SELECT absence.absence_id,absence.user_id,absence.date_value,absence.justifiee,user.login 
        FROM absence,user 
        WHERE absence.user_id=user.user_id 
        AND absence.justifiee=1 
        AND absence.cours_id=:cours_id 
        GROUP BY absence.absence_id');

Absence::addQuery('ABSENCES_NON_JUSTIFIEES_BY_USER', 
        'SELECT absence.absence_id,absence.cours_id,absence.date_value,absence.justifiee,cours.cours_name 
        FROM absence,cours 
        WHERE absence.cours_id=cours.cours_id 
        AND absence.justifiee=0 
        AND absence.user_id=:user_id 
        GROUP BY absence.absence_id');

Absence::addQuery('ABSENCES_JUSTIFIEES_BY_USER', 
        'SELECT absence.absence_id,absence.cours_id,absence.date_value,absence.justifiee,cours.cours_name 
        FROM absence,cours 
        WHERE absence.cours_id=cours.cours_id 
        AND absence.justifiee=1 
        AND absence.user_id=:user_id 
        GROUP BY absence.absence_id');

Absence::addQuery('ABSENCES_NON_JUSTIFIEES', 
        'SELECT absence.absence_id,absence.cours_id,absence.user_id,absence.date_value,absence.justifiee,cours.cours_name,user.login 
        FROM absence,cours,user 
        WHERE absence.cours_id=cours.cours_id 
        AND absence.user_id=user.user_id 
        AND absence.justifiee=0 
        GROUP BY absence.absence_id');

Absence::addQuery('SUPPRIMER_ABSENCE', 
        'DELETE FROM absence 
        WHERE absence_id=:absence_id');
