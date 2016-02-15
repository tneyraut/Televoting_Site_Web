<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$user_id = $_GET["user_id"];
$nombre_de_fautes = $_GET["nombre_de_fautes"];
$nombre_de_bonnes_reponses = $_GET["nombre_de_bonnes_reponses"];
$questionnaire_id = $_GET["questionnaire_id"];

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


    $sql = "SELECT questionnaire_id,malus FROM questionnaire WHERE questionnaire_id=$questionnaire_id";
    $questionnaire = mysqli_query($con, $sql);
    //echo  mysqli_error($con);

    $questionnaireArray = array();
    while ($row = $questionnaire->fetch_object()) {
        array_push($questionnaireArray, $row);
    }

    $sql = "SELECT participant_id,nombre_de_fautes,nombre_de_bonnes_reponses,note FROM participant WHERE participant_id=$participant_id";
    $participant = mysqli_query($con, $sql);

    $participantArray = array();
    while ($row = $participant->fetch_object()) {
        array_push($participantArray, $row);
    }

    $note = $participantArray[0]->note;
    $note = $note + $nombre_de_bonnes_reponses - $nombre_de_fautes * $questionnaireArray[0]->malus;
    if ($note < 0) {
        $note = 0;
    }
    $nombre_de_fautes = $nombre_de_fautes + $participantArray[0]->nombre_de_fautes;
    $nombre_de_bonnes_reponses = $nombre_de_bonnes_reponses + $participantArray[0]->nombre_de_bonnes_reponses;
    $sql = "UPDATE participant SET nombre_de_fautes=$nombre_de_fautes,nombre_de_bonnes_reponses=$nombre_de_bonnes_reponses,note=$note WHERE participant_id=$participant_id";
    mysqli_query($con, $sql);
}

mysqli_close($con);
