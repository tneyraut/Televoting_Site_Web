<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$cours_id = $_GET["cours_id"];

$sql = "SELECT questionnaire_id,cours_id,questionnaire_name,mode_examen,malus,pause 
        FROM questionnaire 
        WHERE cours_id=$cours_id ORDER BY questionnaire_name";

$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($resultat) {
    $questionnaires = array();
    while ($questionnaire = $resultat->fetch_object()) {
        array_push($questionnaires, $questionnaire);
    }
    
    echo json_encode($questionnaires);
    //echo json_last_error_msg();
}

mysqli_close($con);
