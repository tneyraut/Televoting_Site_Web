<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$user_id = $_GET["user_id"];
$questionnaire_id = $_GET["questionnaire_id"];
$question_id = $_GET["question_id"];
$reponse_id = $_GET["reponse_id"];

$sql = "SELECT questionnaire_id,questionnaire_name,lancee FROM questionnaire WHERE questionnaire_id=$quetionnaire_id";
$resultat = mysqli_query($con, $sql);

if ($resultat) {
    $leQuestionnaire = array();
    while ($row = $resultat->fetch_object()) {
        array_push($leQuestionnaire, $row);
    }
}

if ($leQuestionnaire[0]->lancee == 1)
{
    $sql = "SELECT participant_id FROM participant WHERE questionnaire_id=$questionnaire_id AND user_id=$user_id";
    $resultat = mysqli_query($con, $sql);
    //echo  mysqli_error($con);

    if ($resultat) {
        $resultatArray = array();
        while ($row = $resultat->fetch_object()) {
            array_push($resultatArray, $row);
        }
    }
    $participant_id = $resultatArray[0]->participant_id;

    $sql = "INSERT INTO proposition_reponse(participant_id,question_id,reponse_id) VALUES ($participant_id,$question_id,$reponse_id)";

    mysqli_query($con, $sql);
    //echo  mysqli_error($con);
}
mysqli_close($con);
