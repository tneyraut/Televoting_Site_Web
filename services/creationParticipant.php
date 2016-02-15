<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$user_id = $_GET["user_id"];
$annee = $_GET["annee"];

$sql = "SELECT cours_id FROM cours WHERE annee=$annee";

$cours = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($cours) {
    $coursArray = array();
    while ($row = $cours->fetch_object()) {
        array_push($coursArray, $row);
    }
    foreach ($coursArray as $unCours) {
        $sql = "SELECT questionnaire_id FROM questionnaire WHERE cours_id=$unCours->cours_id";
        $questionnaires = mysqli_query($con, $sql);
        if ($questionnaires) {
            $questionnairesArray = array();
            while ($row = $questionnaires->fetch_object()) {
                array_push($questionnairesArray, $row);
            }
            foreach ($questionnairesArray as $questionnaire) {
                $sql = "SELECT COUNT(participant_id) AS nombre FROM participant WHERE user_id=$user_id AND questionnaire_id=$questionnaire->questionnaire_id";
                $participant = mysqli_query($con, $sql);
                if ($participant) {
                    $participantArray = array();
                    while ($row = $participant->fetch_object()) {
                        array_push($participantArray, $row);
                    }
                    if ($participantArray[0]->nombre == 0) {
                        $sql = "INSERT INTO participant(user_id,questionnaire_id) VALUES ($user_id,$questionnaire->questionnaire_id)";
                        mysqli_query($con, $sql);
                    }
                }
            }
        }
    }
}

mysqli_close($con);
