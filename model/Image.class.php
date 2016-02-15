<?php

class Image extends Model
{
    
    public static function imageExiste($image) {
        $resultat = parent::exec('IMAGE_EXISTE', array(':image' => $image));
        if ($resultat != NULL) {
            return true;
        }
        return false;
    }
    
    public static function supprimerImageQuestion($image) {
        unlink($image);
        parent::exec('SUPPRIMER_IMAGE_QUESTION', array(':image' => $image));
    }
    
    public static function supprimerImageReponse($image) {
        unlink($image);
        parent::exec('SUPPRIMER_IMAGE_REPONSE', array(':image' => $image));
    }
    
}
