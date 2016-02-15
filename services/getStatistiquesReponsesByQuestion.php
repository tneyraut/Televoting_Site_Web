<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];
$question_id = $_GET["question_id"];

$sql = "SELECT reponse_id,reponse 
       FROM reponse 
       WHERE question_id=$question_id 
	   ORDER BY reponse_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

$resultatArray = array();

if ($resultat) 
{
    while ($row = $resultat->fetch_object()) {
        array_push($resultatArray, $row);
    }
}

$sql = "SELECT COUNT(participant_id) as nombre_de_participants 
	FROM participant WHERE questionnaire_id=$questionnaire_id";
	
$resultat = mysqli_query($con, $sql);
	
$nombre_de_participants = array();
while ($row = $resultat->fetch_object()) {
	array_push($nombre_de_participants, $row);
}

$finalArray = array();

foreach($resultatArray as $reponse)
{
	$sql = "SELECT COUNT(proposition_reponse.proposition_reponse_id) as nombre_de_reponses 
	FROM proposition_reponse WHERE proposition_reponse.reponse_id=$reponse->reponse_id";
	
	$resultat = mysqli_query($con, $sql);
	
	$value = array();
	while ($row = $resultat->fetch_object()) {
		array_push($value, $row);
	}
	
	$objet = array();
	
	array_push($objet, $reponse->reponse_id);
	array_push($objet, $reponse->reponse);
	array_push($objet, $value[0]->nombre_de_reponses);
	array_push($objet, $nombre_de_participants[0]->nombre_de_participants);
	
	array_push($finalArray,$objet);
}
	
echo json_encode($finalArray);
//echo json_last_error_msg();

mysqli_close($con);
