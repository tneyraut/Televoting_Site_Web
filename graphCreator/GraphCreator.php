<?php

class GraphCreator {
    
    public function creationSimpleHistogramme($donnees, $titre, $legende, $file_name, $Soustitre= "") {
        $GraphiqueWidth = 600;
        $GraphiqueHeight = 400;
        $GraphiqueUnite = 10;
        $GraphiquePolice = 3;

        /* Création de l'image */

        $image = imagecreate($GraphiqueWidth, $GraphiqueHeight);

        /* Définition des couleurs */

        $CouleurCorps = imagecolorallocate($image, 255, 255, 255);
        $CouleurTexte = imagecolorallocate($image, 0x00, 0x33, 0x33);
        $CouleurRectangle = imagecolorallocate($image, 91, 155, 213);
        //$CouleurRectangle1 = imagecolorallocate($image, 0xFF, 0x66, 0x66);
        //$CouleurRectangle2 = imagecolorallocate($image, 0xFF, 0x99, 0x99);
        //$CouleurRectangle3 = imagecolorallocate($image, 0xFF, 0xCC, 0xCC);
        $CouleurHache = imagecolorallocate($image, 0x00, 0x00, 0x00);

        /* Définition de l'arrière-plan */

        imagefill($image, 0, 0, $CouleurCorps);

        /* Création des lignes verticales */

        $TexteHacheWidth = imagefontwidth($GraphiquePolice) * 3 + 1;
        imageline($image, $TexteHacheWidth, 0, $TexteHacheWidth, $GraphiqueHeight - 1, $CouleurHache);

        /* Création des lignes horizontales */

        for ($i = 0; $i < $GraphiqueHeight; $i += $GraphiqueHeight / 10) {
            imagedashedline($image, 0, $i, $GraphiqueWidth - 1, $i, $CouleurHache);
            /* Affichage du nom */
            imagestring($image, $GraphiquePolice, 0, $i, round(($GraphiqueHeight - $i) / $GraphiqueUnite), $CouleurTexte);
        }

        /* Création des lignes du bas du graphique */

        imageline($image, 0, $GraphiqueHeight - 1, $GraphiqueWidth - 1, $GraphiqueHeight - 1, $CouleurHache);

        /* Création des barres */

        $BarreWidth0 = (($GraphiqueWidth / 4 - $TexteHacheWidth) / count($donnees)) - 10;
        
        for ($i = 0; $i < count($donnees); $i++) {
            $BarreWidth = $BarreWidth0 * 3;

            $BarreHautX = $TexteHacheWidth + (($i + 1) * 10) + ($i * $BarreWidth);
            $BarreBottomX = $BarreHautX + $BarreWidth;
            $BarreBottomY = $GraphiqueHeight - 1;

            $BarreHautY = $BarreBottomY - ($donnees[$i] * $GraphiqueUnite);
            imagefilledrectangle($image, $BarreHautX, $BarreHautY, $BarreBottomX - 50, $BarreBottomY, $CouleurRectangle);

            $TexteX = $BarreHautX + (($BarreBottomX - $BarreHautX) / 2) - ( imagefontheight($GraphiquePolice) / 2);
            $TexteY = $BarreBottomY - $donnees[$i] * $GraphiqueUnite;

            //affichage des infos barres
            
            if ($donnees[$i] == 0) {
                imagestring($image, $GraphiquePolice, $TexteX - 24, $TexteY - 40, "$donnees[$i]", $CouleurTexte);
            } else {
                imagestring($image, $GraphiquePolice, $TexteX - 24, $TexteY - 15, "$donnees[$i]", $CouleurTexte);
            }
        }
        
        //affichage des circonstances
        $x = 35;
        foreach ($legende as $uneLegende) {
            imagestring($image, $GraphiquePolice, $x, 385, $uneLegende, $CouleurTexte);
            $x = $x + 110;
        }
        //legende
        //$Resultat = $donnees[0] + $donnees[1] + $donnees[2];
        //$Resultat1 = $GraphiqueDonnee1[0] + $GraphiqueDonnee1[1] + $GraphiqueDonnee1[2] + $GraphiqueDonnee1[3];
        //imagefilledrectangle($image, 400, 25, 415, 10, $CouleurRectangle);
        //imagestring($image, $GraphiquePolice, 420, 10, "" . $Resultat, $CouleurTexte);
        /* imagefilledrectangle($image, 400, 40, 415, 25, $CouleurRectangle1);
          imagestring($image, $GraphiquePolice, 420, 25, " " . $Resultat1, $CouleurTexte); */

        imagestring($image, $GraphiquePolice, 145, 80, $titre, $CouleurTexte);
        imagestring($image, $GraphiquePolice, 145, 100, $Soustitre, $CouleurTexte);
        
        imagepng($image,$file_name);
        
        return $file_name;
    }
    
    public function creationDoubleHistogramme($donnees, $donneesBis, $titre, $legende, $file_name, $Soustitre = "") {
        
        $GraphiqueWidth = 600;
        $GraphiqueHeight = 400;
        $GraphiqueUnite = 10;
        $GraphiquePolice = 3;

        /* Création de l'image */

        $image = imagecreate($GraphiqueWidth, $GraphiqueHeight);

        /* Définition des couleurs */

        $CouleurCorps = imagecolorallocate($image, 255, 255, 255);
        $CouleurTexte = imagecolorallocate($image, 0x00, 0x33, 0x33);
        $CouleurRectangle = imagecolorallocate($image, 91, 155, 213);
        $CouleurRectangle1 = imagecolorallocate($image, 0xFF, 0x66, 0x66);
        //$CouleurRectangle2 = imagecolorallocate($image, 0xFF, 0x99, 0x99);
        //$CouleurRectangle3 = imagecolorallocate($image, 0xFF, 0xCC, 0xCC);
        $CouleurHache = imagecolorallocate($image, 0x00, 0x00, 0x00);

        /* Définition de l'arrière-plan */

        imagefill($image, 0, 0, $CouleurCorps);

        /* Création des lignes verticales */

        $TexteHacheWidth = imagefontwidth($GraphiquePolice) * 3 + 1;
        imageline($image, $TexteHacheWidth, 0, $TexteHacheWidth, $GraphiqueHeight - 1, $CouleurHache);

        /* Création des lignes horizontales */

        for ($i = 0; $i < $GraphiqueHeight; $i += $GraphiqueHeight / 10) {
            imagedashedline($image, 0, $i, $GraphiqueWidth - 1, $i, $CouleurHache);
            /* Affichage du nom */
            imagestring($image, $GraphiquePolice, 0, $i, round(($GraphiqueHeight - $i) / $GraphiqueUnite), $CouleurTexte);
        }

        /* Création des lignes du bas du graphique */

        imageline($image, 0, $GraphiqueHeight - 1, $GraphiqueWidth - 1, $GraphiqueHeight - 1, $CouleurHache);

        /* Création des barres */

        $BarreWidth0 = (($GraphiqueWidth / 4 - $TexteHacheWidth) / count($donnees)) - 10;
        $BarreWidth1 = (($GraphiqueWidth / 4 - $TexteHacheWidth) / count($donneesBis)) - 10;
        
        for ($i = 0; $i < count($donnees); $i++) {
            $BarreWidth = $BarreWidth0 + $BarreWidth1;

            $BarreHautX = $TexteHacheWidth + (($i + 1) * 10) + ($i * $BarreWidth);
            $BarreBottomX = $BarreHautX + $BarreWidth;
            $BarreBottomY = $GraphiqueHeight - 1;

            $BarreHautY = $BarreBottomY - ($donnees[$i] * $GraphiqueUnite);
            $BarreHautY1 = $BarreBottomY - ($donneesBis[$i] * $GraphiqueUnite);
            imagefilledrectangle($image, $BarreHautX, $BarreHautY, $BarreBottomX - 50, $BarreBottomY, $CouleurRectangle);
            imagefilledrectangle($image, $BarreHautX + 17, $BarreHautY1, $BarreBottomX - 33, $BarreBottomY, $CouleurRectangle1);

            $TexteX = $BarreHautX + (($BarreBottomX - $BarreHautX) / 2) - ( imagefontheight($GraphiquePolice) / 2);
            $TexteY = $BarreBottomY - $donnees[$i] * $GraphiqueUnite;
            $TexteY1 = $BarreBottomY - $donneesBis[$i] * $GraphiqueUnite;

            //affichage des infos barres
            
            if ($donnees[$i] == 0) {
                imagestring($image, $GraphiquePolice, $TexteX - 24, $TexteY - 40, "$donnees[$i]", $CouleurTexte);
            } else {
                imagestring($image, $GraphiquePolice, $TexteX - 24, $TexteY - 15, "$donnees[$i]", $CouleurTexte);
            }
            if ($donneesBis[$i] == 0) {
                imagestring($image, $GraphiquePolice, $TexteX - 7, $TexteY1 - 40, "$donneesBis[$i]", $CouleurTexte);
            } else {
                imagestring($image, $GraphiquePolice, $TexteX - 7, $TexteY1 - 15, "$donneesBis[$i]", $CouleurTexte);
            }
        }
        
        //affichage des circonstances
        $x = 20;
        foreach ($legende as $uneLegende) {
            imagestring($image, $GraphiquePolice, $x, 385, $uneLegende, $CouleurTexte);
            $x = $x + 75;
        }
        //legende
        //$Resultat = $donnees[0] + $donnees[1] + $donnees[2];
        //$Resultat1 = $GraphiqueDonnee1[0] + $GraphiqueDonnee1[1] + $GraphiqueDonnee1[2] + $GraphiqueDonnee1[3];
        //imagefilledrectangle($image, 400, 25, 415, 10, $CouleurRectangle);
        //imagestring($image, $GraphiquePolice, 420, 10, "" . $Resultat, $CouleurTexte);
        /* imagefilledrectangle($image, 400, 40, 415, 25, $CouleurRectangle1);
          imagestring($image, $GraphiquePolice, 420, 25, " " . $Resultat1, $CouleurTexte); */

        imagestring($image, $GraphiquePolice, 145, 80, $titre, $CouleurTexte);
        imagestring($image, $GraphiquePolice, 145, 100, $Soustitre, $CouleurTexte);
        
        imagepng($image,$file_name);
        
        return $file_name;
    }
    
}