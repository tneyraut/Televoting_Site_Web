<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];
$questionnaire_name = $_GET["questionnaire_name"];
$mode_examen = $_GET["mode_examen"];
$pause = $_GET["pause"];
$lancee = $_GET["lancee"];
$malus = $_GET["malus"];

$questionnaire_name = str_replace('_', ' ', $questionnaire_name);

$sql = "UPDATE questionnaire SET questionnaire_name='$questionnaire_name',mode_examen=$mode_examen,pause=$pause,lancee=$lancee,malus=$malus WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
