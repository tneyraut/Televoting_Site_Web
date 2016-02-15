<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$reponse_id = $_GET["reponse_id"];

$sql = "DELETE FROM proposition_reponse WHERE reponse_id=$reponse_id";

$resultat = mysqli_query($con, $sql);

$sql = "DELETE FROM reponse WHERE reponse_id=$reponse_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
