<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$cours_id = $_GET["cours_id"];

$sql = "SELECT groupe.groupe_id,groupe.groupe_name 
        FROM groupe,cours 
        WHERE cours.groupe_id=groupe.groupe_id AND cours.cours_id=$cours_id ORDER BY groupe.groupe_name";

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
