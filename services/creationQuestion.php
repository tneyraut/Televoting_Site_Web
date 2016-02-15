<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];
$question = $_GET["question"];
$temps_imparti = $_GET["temps_imparti"];

$question = str_replace('_', ' ', $question);

$sql = "INSERT INTO question(questionnaire_id,question,temps_imparti) 
        VALUES($questionnaire_id,'$question',$temps_imparti)";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
