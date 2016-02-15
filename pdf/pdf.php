<?php

require(__ROOT_DIR__ . '/pdf/fpdf.php');

class PDF extends FPDF
{
    
    var $questionnaire_name;
    var $professeur_name;
    
    function PDF($nomQuestionnaire, $nomProfesseur, $orientation='P', $unit='mm', $size='A4') {
        $this->FPDF($orientation,$unit,$size);
        $this->questionnaire_name = $this->_UTF8toUTF16($nomQuestionnaire);
        $this->professeur_name = $this->_UTF8toUTF16($nomProfesseur);
    }
    
    // En-tête
    function Header() {
        global $titre;
        
        // Logo
        $this->Image(__ROOT_DIR__.'/images/logoMinesDouai.jpg',10,6,30);
        // Arial gras 15
        $this->SetFont('Arial','B',18);
        // Calcul de la largeur du titre et positionnement
        $w = $this->GetStringWidth($titre)+6;
        $this->SetX((210-$w)/2);
        // Titre
        $this->Cell(0,10,$this->_UTF8toUTF16($this->questionnaire_name.' : Résultats'),0,0,'C');
        // Saut de ligne
        $this->Ln(30);
    }
    
    // Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Couleur du texte en gris
        $this->SetTextColor(128);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->SetY(-15);
        $this->Cell(20, 10, $this->_UTF8toUTF16($this->professeur_name), 0, 0, 'C');
    }
    
    function AjouterTitre($num, $libelle) {
        // Arial 12
        $this->SetFont('Arial', '', 14);
        // Couleur de fond
        $this->SetFillColor(255, 255, 255);
        // Titre
        if ($num != NULL) {
        $this->Cell(0, 6, "$num) $libelle", 0, 1, 'L', true);
        }
        else {
            $this->Cell(0, 6, "$libelle", 0, 1, 'L', true);
        }
        // Saut de ligne
        $this->Ln(4);
    }
    
    // Chargement des données
    function LoadData($file) {
        // Lecture des lignes du fichier
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) {
            $data[] = explode(';', trim($line));
        }
        return $data;
    }

// Tableau simple
    function BasicTable($header, $data) {
        // En-tête
        foreach ($header as $col) {
            $this->Cell(30, 10, $this->_UTF8toUTF16($col), 1);
        }
        $this->Ln();
        // Données
        $compteur = 0;
        foreach ($data as $row) {
            $this->Cell(30, 6, $row, 1);
            $compteur++;
            if ($compteur == count($header)) {
                $compteur = 0;
                $this->Ln();
            }
        }
    }

// Tableau amélioré
    function ImprovedTable($header, $data) {
        // Largeurs des colonnes
        $w = array(40, 35, 45, 40);
        // En-tête
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
        // Données
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, number_format($row[2], 0, ',', ' '), 'LR', 0, 'R');
            $this->Cell($w[3], 6, number_format($row[3], 0, ',', ' '), 'LR', 0, 'R');
            $this->Ln();
        }
        // Trait de terminaison
        $this->Cell(array_sum($w), 0, '', 'T');
    }

// Tableau coloré
    function FancyTable($header, $data) {
        // Couleurs, épaisseur du trait et police grasse
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // En-tête
        $w = array(40, 35, 45, 40);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Restauration des couleurs et de la police
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Données
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2], 0, ',', ' '), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3], 0, ',', ' '), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Trait de terminaison
        $this->Cell(array_sum($w), 0, '', 'T');
    }
    
}