<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];

$sql = "SELECT question_id FROM question WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

if ($resultat)
{ 
    while ($row = $resultat->fetch_object()) 
    {
        $sql = "DELETE FROM reponse WHERE question_id=$row->question_id";
        
        $resultat = mysqli_query($con, $sql);
        
        $sql = "DELETE FROM proposition_reponse WHERE question_id=$row->question_id";
        
        $resultat = mysqli_query($con, $sql);
    }
}

$sql = "DELETE FROM question WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

$sql = "DELETE FROM participant WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

$sql = "DELETE FROM questionnaire WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

mysqli_close($con);
