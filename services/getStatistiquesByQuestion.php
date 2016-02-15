<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$question_id = $_GET["question_id"];

$sql = "SELECT question.question_id,question.question,
       COUNT(participant.nombre_de_fautes) AS nombre_de_fautes,
       COUNT(participant.nombre_de_bonnes_reponses) AS nombre_de_bonnes_reponses,
       COUNT(participant.participant_id) AS nombre_de_participants,
       COUNT(reponse.reponse_id) AS nombre_de_reponses 
       FROM question,participant,reponse 
       WHERE question.question_id=$question_id 
       AND participant.questionnaire_id=question.questionnaire_id 
       AND question.question_id=reponse.question_id 
       AND reponse.reponse_correcte=1";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

if ($resultat) 
{
    $resultatArray = array();
    while ($row = $resultat->fetch_object()) {
        array_push($resultatArray, $row);
    }
    echo json_encode($resultatArray);
    //echo json_last_error_msg();
}

mysqli_close($con);
