<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$groupe_id = $_GET["groupe_id"];

$sql = "SELECT user.user_id,user.login 
        FROM user,user_groupe 
        WHERE user.user_id=user_groupe.user_id AND user_groupe.groupe_id=$groupe_id ORDER BY user.login";

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
