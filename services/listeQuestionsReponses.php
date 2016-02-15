<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];

$sql = "SELECT question_id,question,temps_imparti,image FROM question WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

$questions = array();
if ($resultat) {
    while ($row = $resultat->fetch_object()) {
        array_push($questions, $row);
    }
}

$resultatArray = array();

foreach ($questions as $question)
{
    array_push($resultatArray, $question);
    
    $sql = "SELECT reponse_id,reponse,reponse_correcte,image FROM reponse WHERE question_id=$question->question_id";
    
    $resultat = mysqli_query($con, $sql);
    
    $arrayReponse = array();
    if ($resultat) {
        while ($row = $resultat->fetch_object()) {
            array_push($arrayReponse, $row);
        }
    }
    array_push($resultatArray, $arrayReponse);
}


echo json_encode($resultatArray);

mysqli_close($con);
