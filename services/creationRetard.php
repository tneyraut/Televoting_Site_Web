<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$user_id = $_GET["user_id"];
$cours_id = $_GET["cours_id"];
$date_value = $_GET["date_value"];

$sql = "INSERT INTO retard(user_id,cours_id,date_value) 
        VALUES($user_id,$cours_id,'$date_value')";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
