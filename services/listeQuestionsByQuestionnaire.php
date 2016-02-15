<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$user_id = $_GET["user_id"];
$questionnaire_id = $_GET["questionnaire_id"];

$sql = "SELECT participant_id FROM participant WHERE user_id=$user_id AND questionnaire_id=$questionnaire_id";
$participant = mysqli_query($con, $sql);
if ($participant) {
    $participantArray = array();
    while ($row = $participant->fetch_object()) {
        array_push($participantArray, $row);
    }
}
$participant_id = $participantArray[0]->participant_id;

$sql = "SELECT question_id,question,temps_imparti,image 
        FROM question 
        WHERE questionnaire_id=$questionnaire_id 
        AND question_id NOT IN (SELECT question_id FROM proposition_reponse WHERE participant_id=$participant_id)";



$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($resultat) {
    $resultatArray = array();
    while ($row = $resultat->fetch_object()) {
        array_push($resultatArray, $row);
    }
    echo json_encode($resultatArray);
    //echo json_last_error_msg();
}

mysqli_close($con);
