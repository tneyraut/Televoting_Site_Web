<?php 
// Création de la connection
$con = mysqli_connect("localhost","televoting","fu2na4h","televoting");
mysqli_set_charset($con, "utf8");

// Vérification de la connection
if (mysqli_connect_errno()) {
    echo "Echec de connection à MySQL : " . mysqli_connect_errno();
}

$user_id = $_GET["user_id"];

$sql = "SELECT cours.cours_id,cours.cours_name,cours.annee,cours.groupe_id 
        FROM cours,user_groupe 
        WHERE cours.groupe_id=user_groupe.groupe_id 
        AND user_groupe.user_id=$user_id 
        ORDER BY cours.cours_name";

// Vérification s'il y a un résultat
$resultat = mysqli_query($con, $sql);
//echo  mysqli_error($con);

if ($resultat) {
    $cours = array();
    while ($row = $resultat->fetch_object()) {
        //var_dump($row);
        array_push($cours, $row);
    }

    $resultatArray = array();
    foreach ($cours as $unCours) {
        $nombreQuestionnairesAFaire = 0;
        $sql = "SELECT questionnaire_id,questionnaire_name FROM questionnaire WHERE cours_id=$unCours->cours_id AND lancee=1";
        $resultatQuestionnaire = mysqli_query($con, $sql);
        $questionnaires = array();
        while ($rowQuestionnaire = $resultatQuestionnaire->fetch_object()) {
            array_push($questionnaires, $rowQuestionnaire);
        }
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
            if (intval($nombreQuestionsByQuestionnaire) != $nombreQuestionsRepondues) {
                $nombreQuestionnairesAFaire++;
                break;
            }
        }
        if ($nombreQuestionnairesAFaire > 0) {
            array_push($resultatArray, $unCours);
        }
    }

    echo json_encode($resultatArray);
    //echo json_last_error_msg();
}
// fermeture de la connection
mysqli_close($con);
