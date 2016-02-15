<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$question_id = $_GET["question_id"];
$question = $_GET["question"];
$temps_imparti = $_GET["temps_imparti"];

$question = str_replace('_', ' ', $question);

$sql = "UPDATE question SET question='$question',temps_imparti=$temps_imparti WHERE question_id=$question_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
