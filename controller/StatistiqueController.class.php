<?php

require(__ROOT_DIR__ . '/pdf/pdf.php');
require(__ROOT_DIR__ . '/graphCreator/GraphCreator.php');

class StatistiqueController extends Controller
{
    
    public function defaultAction() {
        if (isset($this->user)) {
            $cours = Cours::getCoursByUser($this->user->user_id);
            $this->view->render('statistique/statChoixCours', array('cours' => $cours));
            return new Response();
        }
        $response = new Response();
        $response->redirect('anonymous','login');
        return $response;
    }
    
    public function statChoixQuestionnaireAction()
    {
        $cours_name = $this->request->getPostValue('nomCours');
        $leCours = Cours::getCoursByNameAndUser($this->user->user_id, $cours_name);
        $questionnaires = Questionnaire::getQuestionnaireByCours($cours_name);
        $cours = Cours::getCoursByUser($this->user->user_id);
        $this->view->render('statistique/statChoixQuestionnaire', array(
            'leCours' => $leCours, 
            'questionnaires' => $questionnaires,
            'cours' => $cours
        ));
        return new Response();
    }
    
    public function statistiqueQuestionnaireAction($nomCours)
    {
        $nomCours = str_replace('_', ' ', $nomCours);
        $questionnaire_name = $this->request->getPostValue('nomQuestionnaire');
        $cours = Cours::getCoursByNameAndUser($this->user->user_id, $nomCours);
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $nomCours);
        
        $moyenneNombreBonnesReponses = Participant::getMoyenneNombreDeBonnesReponseByQuestionnaire($questionnaire->questionnaire_id);
        $moyenneNombreFautes = Participant::getMoyenneNombreDeFautesByQuestionnaire($questionnaire->questionnaire_id);
        $moyenneNote = Participant::getMoyenneNoteByQuestionnaire($questionnaire->questionnaire_id);
        $nombreParticipants = Participant::getNombreDeParticipantsByQuestionnaire($questionnaire->questionnaire_id);
        $maxNombreBonnesReponses = Participant::getMaxNombreBonnesReponsesByQuestionnaire($questionnaire->questionnaire_id);
        $maxNombreFautes = Participant::getMaxNombreFautesByQuestionnaire($questionnaire->questionnaire_id);
        $maxNote = Participant::getMaxNoteByQuestionnaire($questionnaire->questionnaire_id);
        $minNombreBonnesReponses = Participant::getMinNombreBonnesReponsesByQuestionnaire($questionnaire->questionnaire_id);
        $minNombreFautes = Participant::getMinNombreFautesByQuestionnaire($questionnaire->questionnaire_id);
        $minNote = Participant::getMinNoteByQuestionnaire($questionnaire->questionnaire_id);
        
        $participants = Participant::getParticipantByQuestionnaireOrderByLogin($questionnaire->questionnaire_id);
        $statistiquesQuestions = Question::getStatistiquesQuestionsByQuestionnaire($questionnaire->questionnaire_id);
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        
        $questionnaires = Questionnaire::getQuestionnaireByCours($nomCours);
        
        $this->view->render('statistique/statQuestionnaire', array(
            'cours' => $cours,
            'questionnaire' => $questionnaire,
            'moyenneNombreBonnesReponses' => $moyenneNombreBonnesReponses,
            'moyenneNombreFautes' => $moyenneNombreFautes,
            'moyenneNote' => $moyenneNote,
            'nombreParticipants' => $nombreParticipants,
            'participants' => $participants,
            'maxNombreBonnesReponses' => $maxNombreBonnesReponses,
            'maxNombreFautes' => $maxNombreFautes,
            'maxNote' => $maxNote,
            'minNombreBonnesReponses' => $minNombreBonnesReponses,
            'minNombreFautes' => $minNombreFautes,
            'minNote' => $minNote,
            'statistiquesQuestions' => $statistiquesQuestions,
            'questions' => $questions,
            'questionnaires' => $questionnaires
        ));
        return new Response();
    }
    
    public function statQuestionAction($nomCours, $questionnaire_name)
    {
        $nomCours = str_replace('_', ' ', $nomCours);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        $question_name = $this->request->getPostValue('question_name');
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $nomCours);
        $question = Question::getQuestionByName($question_name, $questionnaire_name, $nomCours);
        $nombreParticipants = Participant::getNombreDeParticipantsByQuestionnaire($questionnaire->questionnaire_id);
        $nombreBonnesReponsesParticipant = Question::getNombreBonnesReponsesParticipantByQuestion($question->question_id);
        $nombreFautesParticipant = Question::getNombreFautesParticipantByQuestion($question->question_id);
        $nombreTypesReponses = Question::getNombreTypesReponsesByQuestion($question->question_id);
        $nombreReponsesSansReponse = Question::getNombreReponsesSansReponse($question->question_id);
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        $this->view->render('statistique/statQuestion', array(
            'nomCours' => $nomCours,
            'questionnaire_name' => $questionnaire_name,
            'question_name' => $question_name,
            'nombreParticipants' => $nombreParticipants,
            'nombreBonnesReponsesParticipant' => $nombreBonnesReponsesParticipant,
            'nombreFautesParticipant' => $nombreFautesParticipant,
            'nombreTypesReponses' => $nombreTypesReponses,
            'nombreReponsesSansReponse' => $nombreReponsesSansReponse,
            'questions' => $questions
        ));
        
        return new Response();
    }
    
    public function generationPDFAction($cours_name, $questionnaire_name) {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $professeur = User::getProfesseurByQuestionnaire($questionnaire->questionnaire_id);
        
        $moyenneNombreBonnesReponses = Participant::getMoyenneNombreDeBonnesReponseByQuestionnaire($questionnaire->questionnaire_id);
        $moyenneNombreFautes = Participant::getMoyenneNombreDeFautesByQuestionnaire($questionnaire->questionnaire_id);
        $moyenneNote = Participant::getMoyenneNoteByQuestionnaire($questionnaire->questionnaire_id);
        $nombreParticipants = Participant::getNombreDeParticipantsByQuestionnaire($questionnaire->questionnaire_id);
        $maxNombreBonnesReponses = Participant::getMaxNombreBonnesReponsesByQuestionnaire($questionnaire->questionnaire_id);
        $maxNombreFautes = Participant::getMaxNombreFautesByQuestionnaire($questionnaire->questionnaire_id);
        $maxNote = Participant::getMaxNoteByQuestionnaire($questionnaire->questionnaire_id);
        $minNombreBonnesReponses = Participant::getMinNombreBonnesReponsesByQuestionnaire($questionnaire->questionnaire_id);
        $minNombreFautes = Participant::getMinNombreFautesByQuestionnaire($questionnaire->questionnaire_id);
        $minNote = Participant::getMinNoteByQuestionnaire($questionnaire->questionnaire_id);
        $nombreQuestions = Question::getNombreQuestionsByQuestionnaire($questionnaire->questionnaire_id);
        
        $participants = Participant::getParticipantByQuestionnaireOrderByLogin($questionnaire->questionnaire_id);
        
        $creator = new GraphCreator();
        $pdf = new PDF($questionnaire_name, str_replace('.',' ',$professeur->login));
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        $pdf->AjouterTitre(NULL, $pdf->_UTF8toUTF16("Table des matières"));
        
        $pdf->SetFont('Times','',12);
        $pdf->Cell(0,10,$pdf->_UTF8toUTF16("1) Généralités"),0,1);
        $pdf->Cell(0,10,$pdf->_UTF8toUTF16("2) Statistiques par participant"),0,1);
        $pdf->Cell(0,10,$pdf->_UTF8toUTF16("3) Statistiques par question"),0,1);
        
        $pdf->AddPage();
        $pdf->AjouterTitre(NULL, $pdf->_UTF8toUTF16("1) Généralités"));
        $pdf->SetFont('Times','',12);
        $tableau = array(
            'Nom du cours : ' . $cours_name,
            'Nom du questionnaire : ' . $questionnaire_name,
            'Nombre de questions : ' . $nombreQuestions,
            'Nombre de participants : ' . $nombreParticipants,
            'Moyenne des notes : ' . $moyenneNote,
            'Note maximale : ' . $maxNote,
            'Note minimale : ' . $minNote,
            'Nombre moyen de bonnes réponses : ' . $moyenneNombreBonnesReponses,
            'Nombre maximal de bonnes réponses : ' . $maxNombreBonnesReponses,
            'Nombre minimal de bonnes réponses : ' . $minNombreBonnesReponses,
            'Nombre moyen de fautes : ' . $moyenneNombreFautes,
            'Nombre maximal de fautes : ' . $maxNombreFautes,
            'Nombre minimal de fautes : ' . $minNombreFautes
        );
        foreach ($tableau as $element) {
            $pdf->Cell(0,10,$pdf->_UTF8toUTF16($element),0,1);
        }
        $pdf->Ln();
        
        $pdf->AddPage();
        $image = $creator->creationSimpleHistogramme(array($minNote,$moyenneNote,$maxNote), "Comparaison des notes", 
                array('Min','Moyenne','Max'), 'image1.png');
        $pdf->Image($image,10,8,190,0,'png');
        unlink($image);
        
        $pdf->AddPage();
        $image = $creator->creationSimpleHistogramme(array($minNombreBonnesReponses,$moyenneNombreBonnesReponses,$maxNombreBonnesReponses), 
                "Comparaison du nombre de bonnes reponses", array('Min','Moyenne','Max'), 'image2.png');
        $pdf->Image($image,10,8,190,0,'png');
        unlink($image);
        
        $pdf->AddPage();
        $image = $creator->creationSimpleHistogramme(array($minNombreFautes,$moyenneNombreFautes,$maxNombreFautes), 
                "Comparaison du nombre de fautes", array('Min','Moyenne','Max'), 'image3.png');
        $pdf->Image($image,10,8,190,0,'png');
        unlink($image);
        
        $pdf->AddPage();
        $pdf->AjouterTitre(NULL, $pdf->_UTF8toUTF16("2) Statistique par participant"));
        $pdf->SetFont('Times','',10);
        $header = array(
            'Prénom.Nom',
            'Promotion',
            'Année',
            'Note',
            'Bonnes réponses',
            'Fautes'
        );
        $data = array();
        foreach ($participants as $participant) {
            array_push($data, $participant->login);
            array_push($data, $participant->promotion);
            array_push($data, $participant->annee);
            array_push($data, $participant->note);
            array_push($data, $participant->nombre_de_bonnes_reponses);
            array_push($data, $participant->nombre_de_fautes);
        }
        $pdf->BasicTable($header, $data);
        
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        
        $pdf->AddPage();
        $pdf->AjouterTitre(NULL, $pdf->_UTF8toUTF16("3) Statistique par question"));
        
        $array = array(
            'Question',
            'Bonnes réponses',
            'Fautes',
            'Bonnes réponses (%)'
        );
        $tableauQuestion = array();
        $tableauQuestionTitre = array();
        $donnees = array();
        $donneesBis = array();
        $indicateur = array();
        $compteur = 1;
        foreach ($questions as $question) {
            $bonnesReponses = Question::getNombreBonnesReponsesByQuestion($question->question_id);
            $nombreFautes = Question::getNombreFautesParticipantByQuestion($question->question_id);
            array_push($tableauQuestion, $pdf->_UTF8toUTF16('Question N°'.$compteur));
            array_push($tableauQuestion, $bonnesReponses);
            array_push($tableauQuestion, $nombreFautes);
            array_push($tableauQuestion, $bonnesReponses / $nombreParticipants * 100);
            
            array_push($tableauQuestionTitre, $pdf->_UTF8toUTF16('3.'.$compteur.') Question N°'.$compteur.' : ').$pdf->_UTF8toUTF16($question->question));
            
            array_push($donnees, $bonnesReponses);
            array_push($donneesBis, $nombreFautes);
            array_push($indicateur, 'Question '.$compteur);
            
            $compteur++;
        }
        $pdf->SetFont('Times','',10);
        $pdf->BasicTable($array, $tableauQuestion);
        $pdf->Ln();$pdf->Ln();
        
        $pdf->AddPage();
        $image = $creator->creationDoubleHistogramme($donnees, $donneesBis, 
                "Comparaison des questions", $indicateur, 'image4.png', "(Nb bonnes reponses en bleu / Nb fautes en rouge)");
        $pdf->Image($image,10,8,190,0,'png');
        unlink($image);
        
        $headerQuestion = array(
            'Réponse',
            'Nombre',
            'Nombre (%)'
        );
        $dataQuestion = array();
        $compteur = 0;
        foreach ($tableauQuestionTitre as $question) {
            $pdf->AddPage();
            $donnees = array();
            $indicateur = array();
            $nombreTypesReponses = Question::getNombreTypesReponsesByQuestion($questions[$compteur]->question_id);
            foreach ($nombreTypesReponses as $reponse) {
                array_push($dataQuestion, $reponse->reponse);
                array_push($dataQuestion, $reponse->resultat);
                array_push($dataQuestion, $reponse->resultat / $nombreParticipants * 100);
                array_push($indicateur, $reponse->reponse);
                array_push($donnees, $reponse->resultat);
            }
            $pdf->AjouterTitre(NULL, $pdf->_UTF8toUTF16($question));
            $pdf->SetFont('Times','',10);
            $pdf->BasicTable($headerQuestion, $dataQuestion);
            $pdf->Ln();
            
            $pdf->AddPage();
            $fileName = 'image'.($compteur+10).'png';
            $image = $creator->creationSimpleHistogramme($donnees, "Comparaison des reponses la question", 
                    $indicateur, $fileName, $question);
            $pdf->Image($image,10,8,190,0,'png');
            unlink($image);
            
            $compteur++;
            $dataQuestion = array();
        }
        
        $pdf->Output();
        return new Response();
    }
    
}