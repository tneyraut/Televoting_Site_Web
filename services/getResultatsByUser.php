<?php

// Création de la connection
$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

// Vérification de la connection
if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$resultats = array();

$user_id = $_GET["user_id"];
$questionnaire_id = $_GET["questionnaire_id"];

$sql = "SELECT cours.cours_name,questionnaire.questionnaire_name 
        FROM cours,questionnaire 
        WHERE questionnaire.questionnaire_id=$questionnaire_id 
        AND questionnaire.cours_id=cours.cours_id";

$resultat = mysqli_query($con, $sql);

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($resultats, $row);
    }
}


$sql = "SELECT participant_id,user_id,questionnaire_id,nombre_de_fautes,nombre_de_bonnes_reponses,note 
        FROM participant 
        WHERE questionnaire_id=$questionnaire_id 
        AND user_id=$user_id";

// Vérification s'il y a un résultat
$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($resultats, $row);
    }
}


$sql = "SELECT SUM(note) / IF(COUNT(participant_id)=0,1,COUNT(participant_id)) as moyenneNote 
        FROM participant 
        WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($resultats, $row);
    }
}


$sql = "SELECT MAX(note) AS maxNote FROM participant WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($resultats, $row);
    }
}


$sql = "SELECT MIN(note) AS minNote FROM participant WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($resultats, $row);
    }
}


$sql = "SELECT question_id,question,temps_imparti,image FROM question WHERE questionnaire_id=$questionnaire_id ORDER BY question_id";

$resultat = mysqli_query($con, $sql);
$questions = array();

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($questions, $row);
    }
}


$sql = "SELECT (SUM(nombre_de_bonnes_reponses) / IF(COUNT(participant_id)=0,1,COUNT(participant_id))) AS moyenneNombreBonnesReponses 
        FROM participant 
        WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($resultats, $row);
    }
}


$sql = "SELECT (SUM(nombre_de_fautes) / IF(COUNT(participant_id)=0,1,COUNT(participant_id))) AS moyenneNombreFautes 
        FROM participant 
        WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($resultats, $row);
    }
}


$bareme = 0;
$baremeFautes = 0;
foreach ($questions as $question) {
    $sql = "SELECT COUNT(reponse_id) AS resultat 
        FROM reponse 
        WHERE reponse_correcte=1 
        AND question_id=$question->question_id";
    
    $resultat = mysqli_query($con, $sql);
    $nombreBonnesReponses = array();
    if ($resultat) {
        while ($row = $resultat->fetch_object()) {
            array_push($nombreBonnesReponses, $row);
        }
    }
    
    $bareme = $bareme + $nombreBonnesReponses[0]->resultat;
    if ($nombreBonnesReponses[0]->resultat == 0) {
        $bareme++;
    }
    
    $sql = "SELECT reponse_id,reponse,reponse_correcte,image FROM reponse WHERE question_id=$question->question_id ORDER BY reponse";
    $resultat = mysqli_query($con, $sql);
    $reponses = array();
    if ($resultat) {
        while ($row = $resultat->fetch_object()) {
            array_push($reponses, $row);
        }
    }
    $baremeFautes = $baremeFautes + count($reponses);
}
array_push($resultats, $bareme);
array_push($resultats, $baremeFautes);

echo json_encode($resultats);
//echo json_last_error_msg();

// fermeture de la connection
mysqli_close($con);
