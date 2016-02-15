<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];

$sql = "SELECT user.user_id,user.login,user.promotion,user.annee,participant.nombre_de_fautes,participant.nombre_de_bonnes_reponses,participant.note 
       FROM participant,user 
       WHERE participant.user_id=user.user_id AND participant.questionnaire_id=$questionnaire_id 
       ORDER BY user.login";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

if ($resultat) {
    $resultatArray = array();
    while ($row = $resultat->fetch_object()) {
        array_push($resultatArray, $row);
    }
    echo json_encode($resultatArray);
    //echo json_last_error_msg();
}

mysqli_close($con);
