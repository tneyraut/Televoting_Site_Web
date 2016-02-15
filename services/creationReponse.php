<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$question_id = $_GET["question_id"];
$reponse = $_GET["reponse"];
$reponse_correcte = $_GET["reponse_correcte"];

$reponse = str_replace('_', ' ', $reponse);

$sql = "INSERT INTO reponse(question_id,reponse,reponse_correcte) 
        VALUES($question_id,'$reponse',$reponse_correcte)";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
