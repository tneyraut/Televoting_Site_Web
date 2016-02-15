<?php

Image::addQuery('IMAGE_EXISTE', 
        'SELECT question.image,reponse.image 
        FROM question,reponse 
        WHERE question.image=:image OR reponse.image=:image');

Image::addQuery('SUPPRIMER_IMAGE_QUESTION', 'UPDATE question SET image=NULL WHERE image=:image');

Image::addQuery('SUPPRIMER_IMAGE_REPONSE', 'UPDATE reponse SET image=NULL WHERE image=:image');
