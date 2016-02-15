<?php

$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$cours_id = $_GET["cours_id"];
$user_id = $_GET["user_id"];

$sql = "SELECT questionnaire_id,cours_id,questionnaire_name,mode_examen,malus,pause FROM questionnaire WHERE cours_id=$cours_id AND lancee=1 ORDER BY questionnaire_name";

$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($resultat) {
    $questionnaires = array();
    while ($questionnaire = $resultat->fetch_object()) {
        array_push($questionnaires, $questionnaire);
    }
    $resultatArray = array();
    foreach ($questionnaires as $questionnaire) {
        $sql = "SELECT participant_id,questionnaire_id,user_id FROM participant WHERE questionnaire_id=$questionnaire->questionnaire_id AND user_id=$user_id";
        $resultatParticipant = mysqli_query($con, $sql);
        $participant = $resultatParticipant->fetch_object();
        $sql = "SELECT question_id,question FROM question WHERE questionnaire_id=$questionnaire->questionnaire_id";
        $resultatQuestion = mysqli_query($con, $sql);
        $questions = array();
        while ($rowQuestion = $resultatQuestion->fetch_object()) {
            array_push($questions, $rowQuestion);
        }
        $nombreQuestionsByQuestionnaire = count($questions);
        $nombreQuestionsRepondues = 0;
        foreach ($questions as $question) {
            $sql = "SELECT COUNT(proposition_reponse_id) AS resultat FROM proposition_reponse WHERE question_id=$question->question_id AND participant_id=$participant->participant_id";
            $resultatPropositionReponse = mysqli_query($con, $sql);
            $propositionReponse = $resultatPropositionReponse->fetch_object();
            if ($propositionReponse->resultat > 0) {
                $nombreQuestionsRepondues++;
            }
        }
        if ($nombreQuestionsRepondues < $nombreQuestionsByQuestionnaire) {
            array_push($resultatArray, $questionnaire);
        }
    }
    echo json_encode($resultatArray);
    //echo json_last_error_msg();
}

mysqli_close($con);
