<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$question_id = $_GET["question_id"];

$sql = "SELECT reponse_id,question_id,reponse,reponse_correcte,image FROM reponse WHERE question_id=$question_id ORDER BY reponse";

$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($resultat) {
    $resultatArray = array();
    while ($row = $resultat->fetch_object()) {
        array_push($resultatArray, $row);
    }
    echo json_encode($resultatArray);
    //echo json_last_error_msg();
}

mysqli_close($con);
