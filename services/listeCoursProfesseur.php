<?php 
// Création de la connection
$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

// Vérification de la connection
if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$user_id = $_GET["user_id"];

$sql = "SELECT cours_id,cours_name,annee,groupe_id,user_id FROM cours WHERE user_id=$user_id ORDER BY cours_name";

// Vérification s'il y a un résultat
$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($resultat) {
    $cours = array();
    while ($row = $resultat->fetch_object()) {
        //var_dump($row);
        array_push($cours, $row);
    }
    
    echo json_encode($cours);
    //echo json_last_error_msg();
}
// fermeture de la connection
mysqli_close($con);
