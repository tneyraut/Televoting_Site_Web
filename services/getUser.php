<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$login = $_GET["login"];
$password = $_GET["password"];
$password = sha1($password);

$sql = "SELECT user_id,login,annee,professeur FROM user WHERE login='$login' AND password='$password'";

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
