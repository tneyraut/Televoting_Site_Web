<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$reponse_id = $_GET["reponse_id"];
$reponse = $_GET["reponse"];
$reponse_correcte = $_GET["reponse_correcte"];

$reponse = str_replace('_', ' ', $reponse);

$sql = "UPDATE reponse SET reponse='$reponse',reponse_correcte=$reponse_correcte WHERE reponse_id=$reponse_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
