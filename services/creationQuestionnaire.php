<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$cours_id = $_GET["cours_id"];
$questionnaire_name = $_GET["questionnaire_name"];

$questionnaire_name = str_replace('_', ' ', $questionnaire_name);

$sql = "INSERT INTO questionnaire(cours_id,questionnaire_name,mode_examen,malus,pause,lancee) 
        VALUES($cours_id,'$questionnaire_name',0,0,1,0)";

$resultat = mysqli_query($con, $sql);
//echo mysqli_error($con);

$sql = "SELECT user.user_id,user.login FROM user,user_groupe,groupe,cours WHERE user_groupe.user_id=user.user_id AND user_groupe.groupe_id=cours.groupe_id AND cours.cours_id=$cours_id GROUP BY user.user_id";

$resultat = mysqli_query($con, $sql);

$users = array();
while ($row = $resultat->fetch_object()) {
    array_push($users, $row);
}

$sql = "SELECT questionnaire_id,questionnaire_name FROM questionnaire WHERE questionnaire_name='$questionnaire_name' AND cours_id=$cours_id";

$resultat = mysqli_query($con, $sql);

$questionnaire = array();
while ($row = $resultat->fetch_object()) {
    array_push($questionnaire, $row);
}

$leQuestionnaire = $questionnaire[0];

foreach ($users as $user)
{
    $sql = "INSERT INTO participant(user_id,questionnaire_id,nombre_de_fautes,nombre_de_bonnes_reponses,note) 
            VALUES($user->user_id,$leQuestionnaire->questionnaire_id,0,0,0)";
    
    $resultat = mysqli_query($con, $sql);
}

mysqli_close($con);
