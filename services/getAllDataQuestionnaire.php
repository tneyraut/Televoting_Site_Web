<?php 
// Création de la connection
$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

// Vérification de la connection
if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];

$sql = "SELECT question_id,question,temps_imparti FROM question WHERE questionnaire_id=$questionnaire_id ORDER BY question_id";

$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

$questions = array();
if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        //var_dump($row);
        array_push($questions, $row);
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


$sql = "SELECT questionnaire.questionnaire_id,questionnaire.questionnaire_name,questionnaire.mode_examen,questionnaire.malus,questionnaire.pause,questionnaire.lancee,cours.cours_name 
		FROM cours,questionnaire 
		WHERE cours.cours_id=questionnaire.cours_id AND questionnaire.questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

$arrayResultat = array();
if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        //var_dump($row);
        array_push($arrayResultat, $row);
    }
}

array_push($arrayResultat, $bareme);
array_push($arrayResultat, $baremeFautes);

echo json_encode($arrayResultat);

// fermeture de la connection
mysqli_close($con);
