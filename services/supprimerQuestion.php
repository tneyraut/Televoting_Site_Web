<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$question_id = $_GET["question_id"];

$sql = "DELETE FROM reponse WHERE question_id=$question_id";

$resultat = mysqli_query($con, $sql);

$sql = "DELETE FROM proposition_reponse WHERE question_id=$question_id";

$resultat = mysqli_query($con, $sql);

$sql = "DELETE FROM question WHERE question_id=$question_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
