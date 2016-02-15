<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$questionnaire_id = $_GET["questionnaire_id"];

$sql = "UPDATE participant SET nombre_de_fautes=0,nombre_de_bonnes_reponses=0,note=0 WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

$sql = "SELECT participant_id FROM participant WHERE questionnaire_id=$questionnaire_id";

$resultat = mysqli_query($con, $sql);

if ($resultat) 
{
    while ($row = $resultat->fetch_object()) 
    {
        $requete = "DELETE FROM proposition_reponse WHERE participant_id=$row->participant_id";
        mysqli_query($con, $requete);
    }
}

mysqli_close($con);
