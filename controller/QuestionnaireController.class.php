<?php

class QuestionnaireController extends Controller
{
    
    public function defaultAction() {
        return new Response();
    }
    
    public function listeCoursAction() {
        if (isset($this->user)) {
            $cours = Cours::getCoursByUser($this->user->user_id);
            $this->view->render('questionnaire/listeCours', array('cours' => $cours));
            return new Response();
        }
        $response = new Response();
        $response->redirect('anonymous','login');
        return $response;
    }
    
    public function listeQuestionnairesAction() {
        $nomCours = $this->request->getPostValue('nomCours');
        $cours = Cours::getCoursByUser($this->user->user_id);
        $questionnaires = Questionnaire::getQuestionnaireByCours($nomCours);
        $this->view->render('questionnaire/listeQuestionnaire', array('cours' => $cours, 'questionnaires' => $questionnaires, 'nomCours' => $nomCours));
        return new Response();
    }
    
    public function listeQuestionAction($nomCours) {
        $nomCours = str_replace('_', ' ', $nomCours);
        
        $nomQuestionnaire = $this->request->getPostValue('nomQuestionnaire');
        $suppression = $this->request->getPostValue('suppression');
        $reinitialisation = $this->request->getPostValue('reinitialisation');
        $questionnaire = Questionnaire::getQuestionnaireByName($nomQuestionnaire, $nomCours);
        if ($suppression == "Oui") {
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            if ($questions != NULL) {
                foreach ($questions as $question) {
                    Reponse::supprimerReponsesByQuestion($question->question_id);
                }
            }
            Proposition_Reponse::supprimerPropositionReponseByQuestionnaire($questionnaire->questionnaire_id);
            Participant::supprimerParticipantsByQuestionnaire($questionnaire->questionnaire_id);
            Question::supprimerQuestionsByQuestionnaire($questionnaire->questionnaire_id);
            Questionnaire::supprimerQuestionnaireByID($questionnaire->questionnaire_id);
            
            $cours = Cours::getCoursByUser($this->user->user_id);
            $questionnaires = Questionnaire::getQuestionnaireByCours($nomCours);
            $this->view->render('questionnaire/listeQuestionnaire', array('questionnaires' => $questionnaires, 'nomCours' => $nomCours, 'cours' => $cours));
            return new Response();
        }
        if ($reinitialisation == "Oui") {
            $participants = Participant::getParticipantsByQuestionnaire($questionnaire->questionnaire_id);
            Participant::reinitialisationParticipantsByQuestionnaire($questionnaire->questionnaire_id);
            foreach ($participants as $participant) {
                Proposition_Reponse::supprimerPropostionReponseByParticipant($participant->participant_id);
            }
            $cours = Cours::getCoursByUser($this->user->user_id);
            $questionnaires = Questionnaire::getQuestionnaireByCours($nomCours);
            $this->view->render('questionnaire/listeQuestionnaire', array('questionnaires' => $questionnaires, 'nomCours' => $nomCours, 'cours' => $cours));
            return new Response();
        }
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        $cours = Cours::getCoursByUser($this->user->user_id);
        $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
        $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
        $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
        
        $this->view->render('questionnaire/questionQuestionnaire', array(
            'questionnaire' => $questionnaire, 
            'questions' => $questions, 
            'cours' => $cours,
            'reponses' => $reponses,
            'bareme' => $bareme,
            'baremeFautes' => $baremeFautes
            ));
        return new Response();
    }
    
    public function modificationQuestionnaireAction($cours_name,$questionnaire_name) {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        //BUG PHP 
        //$nouveauNomCours = $this->request->getPostValue('nomCours');
        $nouveauNomCours = $cours_name;
        //FIN BUG PHP
        
        $nomQuestionnaire = $this->request->getPostValue('nomQuestionnaire');
        $modeExamen = $this->request->getPostValue('modeExamen');
        $malus = $this->request->getPostValue('malus');
        $pause = $this->request->getPostValue('pause');
        $lancee = $this->request->getPostValue('lancee');
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        if ($malus == "") {
            $malus = $questionnaire->malus;
        }
        else if (!is_numeric($malus) || $malus < 0) {
            $nomQuestionnaire = $questionnaire_name;
            $nomCours = $cours_name;
            $questionnaire = Questionnaire::getQuestionnaireByName($nomQuestionnaire, $nomCours);
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $cours = Cours::getCoursByUser($this->user->user_id);
            $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            $this->view->render('questionnaire/questionQuestionnaire', array(
                'questionnaire' => $questionnaire, 
                'questions' => $questions, 
                'cours' => $cours, 
                'reponses' => $reponses,
                'erreur' => "Champs malus incorrect.",
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
                ));
        }
        
        $problem = Questionnaire::miseAJourQuestionnaire($questionnaire_name, $nomQuestionnaire, $modeExamen, $nouveauNomCours, $cours_name, $this->user->user_id, $malus, $pause, $lancee);
        if ($problem) {
            $nomQuestionnaire = $questionnaire_name;
            $nomCours = $cours_name;
            $questionnaire = Questionnaire::getQuestionnaireByName($nomQuestionnaire, $nomCours);
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $cours = Cours::getCoursByUser($this->user->user_id);
            $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            $this->view->render('questionnaire/questionQuestionnaire', array(
                'questionnaire' => $questionnaire, 
                'questions' => $questions, 
                'cours' => $cours, 
                'reponses' => $reponses,
                'erreur' => "Ce nom de questionnaire existe déjà.",
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
                ));
        }
        else {
            if ($nomQuestionnaire == '') {
                $nomQuestionnaire = $questionnaire_name;
            }
            $questionnaire = Questionnaire::getQuestionnaireByName($nomQuestionnaire, $nouveauNomCours);
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $cours = Cours::getCoursByUser($this->user->user_id);
            $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            $this->view->render('questionnaire/questionQuestionnaire', array(
                'questionnaire' => $questionnaire, 
                'questions' => $questions, 
                'cours' => $cours,
                'reponses' => $reponses,
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
                ));
        }
        return new Response();
    }
    
    public function selectionQuestionAction($nomCours, $nomQuestionnaire) {
        $nomCours = str_replace('_', ' ', $nomCours);
        $nomQuestionnaire = str_replace('_', ' ', $nomQuestionnaire);
        $question_contenu = $this->request->getPostValue('nomQuestion');
        $suppression = $this->request->getPostValue('suppression');
        $question = Question::getQuestionByName($question_contenu,$nomQuestionnaire,$nomCours);
        $questionnaire = Questionnaire::getQuestionnaireByName($nomQuestionnaire, $nomCours);
        if ($suppression == "Oui") {
            Proposition_Reponse::supprimerPropositionReponseByQuestion($question->question_id);
            Reponse::supprimerReponsesByQuestion($question->question_id);
            Question::supprimerQuestionById($question->question_id); 
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $cours = Cours::getCoursByUser($this->user->user_id);
            $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            $this->view->render('questionnaire/questionQuestionnaire', array(
                'questionnaire' => $questionnaire, 
                'questions' => $questions, 
                'cours' => $cours,
                'reponses' => $reponses,
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
                ));
            return new Response();
        }
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        $reponses = Reponse::getReponseByQuestionId($question->question_id);
        $this->view->render('questionnaire/reponseQuestionnaire', array(
            'question' => $question, 
            'reponses' => $reponses, 
            'questions' => $questions,
            'cours_name' => $nomCours,
            'questionnaire_name' => $nomQuestionnaire
        ));
        return new Response();
    }
    
    public function modificationQuestionAction($question_id, $cours_name, $questionnaire_name) {
        $cours_name = str_replace('_',' ',$cours_name);
        $questionnaire_name = str_replace('_',' ',$questionnaire_name);
        $response = new Response();
        $question = Question::getQuestionById($question_id);
        $question_contenu = $this->request->getPostValue('question_contenu');
        $temps_imparti = $this->request->getPostValue('temps_imparti');
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        $image = "";
        if ($this->request->getPostValue('supprimer_image') == "Oui") {
            Image::supprimerImageQuestion($question->image);
        }
        if ($question->image != "") {
            $image = $question->image;
        }
        if ($_FILES['image']['name'] != "") {
            if ($question->image != "") {
                Image::supprimerImageQuestion($question->image);
            }
            /*if ($_FILES['icone']['size'] > $maxsize) {
            $erreur = "Erreur : Image trop lourde";
            }*/
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            if (!in_array($extension_upload,$extensions_valides)){
                $erreur = "Erreur : image non valide, problème d'extension";
            }
            /*$image_sizes = getimagesize($_FILES['image']['tmp_name']);
            if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) {
                $erreur = "Erreur : Image trop grande";
            }*/
            $image = "images/imagesUpload/".rand().".".$extension_upload;
            while (Image::imageExiste($image)) {
                $image = "images/imagesUpload/".rand().".".$extension_upload;
            }
            move_uploaded_file($_FILES['image']['tmp_name'],$image);
            //var_dump($_FILES['image']);
        }
        
        if ($question_contenu == "") {
            $question_contenu = $question->question;
        }
        if ($temps_imparti != "" && !is_numeric($temps_imparti)) {
            $question = Question::getQuestionById($question_id);
            $reponses = Reponse::getReponseByQuestionId($question->question_id);
            $this->view->render('questionnaire/reponseQuestionnaire', array(
                'question' => $question, 
                'reponses' => $reponses, 
                'questions' => $questions,
                'cours_name' => $cours_name,
                'questionnaire_name' => $questionnaire_name,
                'erreur' => "Temps imparti saisi non conforme."
            ));
            return $response;
        }
        if ($temps_imparti == "") {
            $temps_imparti = $question->temps_imparti;
        }
        Question::miseAJourQuestion($question_id, $question_contenu, $temps_imparti,$image);
        
        $laQuestion = Question::getQuestionById($question_id);
        $reponses = Reponse::getReponseByQuestionId($question_id);
        
        $this->view->render('questionnaire/reponseQuestionnaire', array(
            'question' => $laQuestion, 
            'reponses' => $reponses,
            'questions' => $questions,
            'cours_name' => $cours_name,
            'questionnaire_name' => $questionnaire_name
        ));
        return $response;
    }
    
    public function modificationReponseAction($question_id, $reponse_id, $cours_name, $questionnaire_name) 
    {
        $cours_name = str_replace('_',' ',$cours_name);
        $questionnaire_name = str_replace('_',' ',$questionnaire_name);
        $reponse_contenu = $this->request->getPostValue('reponse_contenu');
        $reponse_correcte = $this->request->getPostValue('reponse_correcte');
        $reponse = Reponse::getReponseById($reponse_id);
        $suppression = $this->request->getPostValue('suppression');
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        
        if ($this->request->getPostValue('supprimer_image') == "Oui" || $_FILES['image']['name'] != "") {
            Image::supprimerImageReponse($reponse->image);
        }
        
        $image = "";
        if ($reponse->image != "") {
            $image = $reponse->image;
        }
        if ($_FILES['image']['name'] != "") {
            if ($reponse->image != "") {
                Image::supprimerImageReponse($reponse->image);
            }
            /*if ($_FILES['icone']['size'] > $maxsize) {
            $erreur = "Erreur : Image trop lourde";
            }*/
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            if (!in_array($extension_upload,$extensions_valides)){
                $erreur = "Erreur : image non valide, problème d'extension";
            }
            /*$image_sizes = getimagesize($_FILES['image']['tmp_name']);
            if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) {
                $erreur = "Erreur : Image trop grande";
            }*/
            $image = "images/imagesUpload/".rand().".".$extension_upload;
            while (Image::imageExiste($image)) {
                $image = "images/imagesUpload/".rand().".".$extension_upload;
            }
            move_uploaded_file($_FILES['image']['tmp_name'],$image);
            //var_dump($_FILES['image']);
        }
        
        if ($suppression == "Oui") {
            Reponse::supprimerReponseById($reponse_id);
        }
        else {
            if ($reponse_contenu == "") {
                $reponse_contenu = $reponse->reponse;
            }
            if ($reponse_correcte == "Oui") {
                $reponse_correcte = 1;
            }
            else {
                $reponse_correcte = 0;
            }
            Reponse::miseAJourReponse($reponse_contenu, $reponse_correcte, $reponse_id, $image);
        }
        $question = Question::getQuestionById($question_id);
        $reponses = Reponse::getReponseByQuestionId($question_id);
        $this->view->render('questionnaire/reponseQuestionnaire', array(
            'question' => $question, 
            'reponses' => $reponses,
            'cours_name' => $cours_name,
            'questionnaire_name' => $questionnaire_name,
            'questions' => $questions
        ));
        return new Response();
    }
    
    public function ajouterQuestionnaireAction($nomCours)
    {
        $nomCours = str_replace('_', ' ', $nomCours);
        $questionnaire_name = $this->request->getPostValue('questionnaire_name');
        $cours = Cours::getCoursByNameAndUser($this->user->user_id,$nomCours);
        $Usercours = Cours::getCoursByUser($this->user->user_id);
        if ($questionnaire_name == "" || ($questionnaire_name != "" && Questionnaire::nomQuestionnaireExist($questionnaire_name, $cours->cours_name))) {
            $questionnaires = Questionnaire::getQuestionnaireByCours($nomCours);
            $this->view->render('questionnaire/listeQuestionnaire', array(
                'cours' => $Usercours, 'questionnaires' => $questionnaires, 'nomCours' => $nomCours, 'erreur' => "Erreur :  nom de questionnaire incorrect."
                ));
            return new Response();
        }
        $malus = $this->request->getPostValue('malus');
        if ($malus == "") {
            $malus = 0;
        }
        else if (!is_numeric($malus) || $malus < 0) {
            $questionnaires = Questionnaire::getQuestionnaireByCours($nomCours);
            $this->view->render('questionnaire/listeQuestionnaire', array(
                'cours' => $Usercours, 'questionnaires' => $questionnaires, 'nomCours' => $nomCours, 'erreur' => "Erreur :  Champs malus incorrect."
                ));
            return new Response();
        }
        $mode_examen = $this->request->getPostValue('mode_examen');
        $pause = $this->request->getPostValue('pause');
        Questionnaire::ajouterQuestionnaire($cours->cours_id, $questionnaire_name, $mode_examen, $malus, $pause);
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $nomCours);
        $eleves = User::getUsersByGroupeId($cours->groupe_id);
        foreach ($eleves as $unEleve) {
            Participant::ajouterParticipant($unEleve->user_id, $questionnaire->questionnaire_id, 0, 0, 0);
        }
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
        $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
        $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
        $this->view->render('questionnaire/questionQuestionnaire', array(
            'questionnaire' => $questionnaire, 
            'questions' => $questions, 
            'cours' => $Usercours,
            'reponses' => $reponses,
            'bareme' => $bareme,
            'baremeFautes' => $baremeFautes
            ));
        return new Response();
    }
    
    public function ajouterQuestionAction($cours_name, $questionnaire_name)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        $question_contenu = $this->request->getPostValue('question');
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        if ($question_contenu == "" || ($question_contenu != "" && Question::questionExiste($questionnaire->questionnaire_id,$question_contenu))) {
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $cours = Cours::getCoursByUser($this->user->user_id);
            $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            $this->view->render('questionnaire/questionQuestionnaire', array(
                'questionnaire' => $questionnaire, 
                'questions' => $questions, 
                'cours' => $cours, 
                'reponses' => $reponses,
                'erreur' => "Cette question existe déjà.",
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
                ));
            return new Response();
        }
        
        $image = "";
        if ($_FILES['image']['name'] != "") {
            /*if ($_FILES['icone']['size'] > $maxsize) {
            $erreur = "Erreur : Image trop lourde";
            }*/
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            if (!in_array($extension_upload,$extensions_valides)){
                $erreur = "Erreur : image non valide, problème d'extension";
            }
            /*$image_sizes = getimagesize($_FILES['image']['tmp_name']);
            if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) {
                $erreur = "Erreur : Image trop grande";
            }*/
            $image = "images/imagesUpload/".rand().".".$extension_upload;
            while (Image::imageExiste($image)) {
                $image = "images/imagesUpload/".rand().".".$extension_upload;
            }
            move_uploaded_file($_FILES['image']['tmp_name'],$image);
            //var_dump(move_uploaded_file($_FILES['image']['tmp_name'],$image));
            //var_dump($_FILES['image']['error']);
        }
        
        $temps_imparti = $this->request->getPostValue('temps_imparti');
        if ($temps_imparti != "" && !is_numeric($temps_imparti)) {
            $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
            $cours = Cours::getCoursByUser($this->user->user_id);
            $reponses = Reponse::getReponsesByQuestionnaire($questionnaire->questionnaire_id);
            $bareme = Questionnaire::getBareme($questionnaire->questionnaire_id);
            $baremeFautes = Questionnaire::getBaremeFautes($questionnaire->questionnaire_id);
            $this->view->render('questionnaire/questionQuestionnaire', array(
                'questionnaire' => $questionnaire, 
                'questions' => $questions, 
                'cours' => $cours, 
                'reponses' => $reponses,
                'erreur' => "Champs temps imparti incorrect.",
                'bareme' => $bareme,
                'baremeFautes' => $baremeFautes
                ));
            return new Response();
        }
        if ($temps_imparti == "" || (is_numeric($temps_imparti) && $temps_imparti < 0)) {
            $temps_imparti = 0;
        }
        Question::ajouterQuestion($questionnaire->questionnaire_id, $question_contenu, $temps_imparti,$image);
        $question = Question::getQuestionByName($question_contenu, $questionnaire_name, $cours_name);
        $reponses = Reponse::getReponseByQuestionId($question->question_id);
        $this->view->render('questionnaire/reponseQuestionnaire', array(
            'question' => $question, 
            'reponses' => $reponses,
            'cours_name' => $cours_name,
            'questionnaire_name' => $questionnaire_name,
            'questions' => $questions
        ));
        return new Response();
    }
    
    public function ajouterReponseAction($question_id, $cours_name, $questionnaire_name)
    {
        $cours_name = str_replace('_', ' ', $cours_name);
        $questionnaire_name = str_replace('_', ' ', $questionnaire_name);
        $nouvelle_reponse = $this->request->getPostValue('nouvelle_reponse');
        $nouvelle_reponse_correcte = $this->request->getPostValue('nouvelle_reponse_correcte');
        $question = Question::getQuestionById($question_id);
        $questionnaire = Questionnaire::getQuestionnaireByName($questionnaire_name, $cours_name);
        $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
        
        $image = "";
        if ($_FILES['image']['name'] != "") {
            /*if ($_FILES['icone']['size'] > $maxsize) {
            $erreur = "Erreur : Image trop lourde";
            }*/
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
            $extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
            if (!in_array($extension_upload,$extensions_valides)){
                $erreur = "Erreur : image non valide, problème d'extension";
            }
            /*$image_sizes = getimagesize($_FILES['image']['tmp_name']);
            if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight) {
                $erreur = "Erreur : Image trop grande";
            }*/
            $image = "images/imagesUpload/".rand().".".$extension_upload;
            while (Image::imageExiste($image)) {
                $image = "images/imagesUpload/".rand().".".$extension_upload;
            }
            move_uploaded_file($_FILES['image']['tmp_name'],$image);
            //var_dump($_FILES['image']);
        }
        
        if ($nouvelle_reponse == "" || ($nouvelle_reponse != "" && Reponse::reponseExiste($question_id, $nouvelle_reponse))) {
            $reponses = Reponse::getReponseByQuestionId($question_id);
            $this->view->render('questionnaire/reponseQuestionnaire', array(
                'question' => $question, 
                'reponses' => $reponses,
                'questions' => $questions,
                'cours_name' => $cours_name,
                'questionnaire_name' => $questionnaire_name,
                'erreur' => "Contenu de la réponse incorrect."
            ));
            return new Response();
        }
        Reponse::ajouterReponse($question_id, $nouvelle_reponse, $nouvelle_reponse_correcte, $image);
        $reponses = Reponse::getReponseByQuestionId($question_id);
        $this->view->render('questionnaire/reponseQuestionnaire', array(
            'question' => $question, 
            'reponses' => $reponses,
            'questions' => $questions,
            'cours_name' => $cours_name,
            'questionnaire_name' => $questionnaire_name
        ));
        return new Response();
    }
    
}