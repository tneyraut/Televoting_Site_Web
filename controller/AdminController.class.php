<?php

require_once (__ROOT_DIR__ . '/Excel/reader.php');

class AdminController extends Controller 
{
    
    public function defaultAction()
    {
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        $this->view->render('admin/listeUsers', array(
            'users' => $users,
            'groupes' => $groupes
            ));
        return new Response();
    }
    
    public function supprimerUserAction()
    {
        $response = new Response();
        $nomUser = $this->request->getPostValue('nomUser');
        $user_name = $this->request->getPostValue('user_name');
        $userName = $nomUser;
        if ($user_name != "") {
            if (User::isLoginUsed($user_name)) {
                $userName = $user_name;
            }
            else {
                $users = User::getUsers();
                $groupes = Groupe::getListeGroupes();
                $this->view->render('admin/listeUsers', array(
                    'users' => $users, 
                    'erreur' => "Ce nom d'utilisateur n'existe pas.",
                    'groupes' => $groupes
                    ));
                return new Response();
            }
        }
        $userASuppr = User::getUserByLogin($userName);
        $cours = Cours::getCoursByUser($userASuppr->user_id);
        foreach ($cours as $unCours) {
            $nombreDeProfesseurs = Cours::getNombreDeProfesseursByCours($unCours->cours_name);
            if ($nombreDeProfesseurs == 1) {
                $questionnaires = Questionnaire::getQuestionnaireByCours($unCours->cours_name);
                foreach ($questionnaires as $questionnaire) {
                    $questions = Question::getQuestionByQuestionnaire($questionnaire->questionnaire_id);
                    foreach ($questions as $question) {
                        Reponse::supprimerReponsesByQuestion($question->question_id);
                    }
                    Question::supprimerQuestionsByQuestionnaire($questionnaire->questionnaire_id);
                }
                Questionnaire::supprimerQuestionnairesByCours($unCours->cours_id);
                Cours::supprimerCoursById($unCours->cours_id);
            }
        }
        Proposition_Reponse::supprimerPropositionReponseByUser($userASuppr->user_id);
        Participant::supprimerParticipantsByUser($userASuppr->user_id);
        User_Groupe::supprimerUserGroupeByUserId($userASuppr->user_id);
        User::supprimerUser($userName);
        
        $response->redirect('admin');
        return $response;
    }
    
    public function ajouterUserAction()
    {
        $response = new Response();
        $login = $this->request->getPostValue('login');
        $password =  SHA1($this->request->getPostValue('password'));
        $professeur = $this->request->getPostValue('professeur');
        $admin = $this->request->getPostValue('admin');
        $annee = $this->request->getPostValue('annee');
        $promotion = $this->request->getPostValue('promotion');
        $confirmation = SHA1($this->request->getPostValue('confirmation'));
        $groupe_name = $this->request->getPostValue('groupe_name');
        if (User::isLoginUsed($login)) {
            $users = User::getUsers();
            $groupes = Groupe::getListeGroupes();
            $this->view->render('admin/listeUsers', array(
                'users' => $users, 
                'erreur' => "Ce login existe déjà.",
                'groupes' => $groupes
                ));
            return new Response();
        }
        if ($annee != "" && (!is_int((int)$annee) || $annee > 5)) {
            $users = User::getUsers();
            $groupes = Groupe::getListeGroupes();
            $this->view->render('admin/listeUsers', array(
                'users' => $users, 
                'erreur' => "Erreur de saisi dans le champs année.",
                'groupes' => $groupes
                ));
            return new Response();
        }
        if ($login == "" || $password == "" || $confirmation == "" || ($professeur == "eleve" && ($annee == "" || $promotion == ""))) {
            $users = User::getUsers();
            $groupes = Groupe::getListeGroupes();
            $this->view->render('admin/listeUsers', array(
                'users' => $users, 
                'erreur' => "Erreur de saisi, champs manquant.",
                'groupes' => $groupes
                ));
            return new Response();
        }
        if ($password != $confirmation) {
            $users = User::getUsers();
            $this->view->render('admin/listeUsers', array(
                'users' => $users, 
                'erreur' => "Erreur de saisi dans la confirmation du mot de passe.",
                'groupes' => $groupes
                ));
            return new Response();
        }
        $groupe = Groupe::getGroupeByName($groupe_name);
        User::ajouterUser($login, $password, $admin, $professeur, $annee, $promotion, $groupe->groupe_id);
        $response->redirect('admin');
        return $response;
    }
    
    public function ajouterSupprimerCoursAction()
    {
        $cours = Cours::getCours();
        $professeurs = User::getProfesseurs();
        $groupes = Groupe::getListeGroupes();
        $this->view->render('admin/listeCoursAdmin',array(
            'cours' => $cours, 
            'professeurs' => $professeurs,
            'groupes' => $groupes
            ));
        return new Response();
    }
    
    public function ajouterCoursAction()
    {
        $response = new Response();
        $cours_name = $this->request->getPostValue('cours_name');
        $annee = $this->request->getPostValue('annee');
        $professeur_name = $this->request->getPostValue('professeur_name');
        $groupe_name = $this->request->getPostValue('groupe_name');
        $professeur = User::getUserByLogin($professeur_name);
        $cours = Cours::getCours();
        $professeurs = User::getProfesseurs();
        $groupes = Groupe::getListeGroupes();
        if (!is_numeric($annee)) {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes,
                'erreur' => "Champ Année incorrect, veuillez rentrer un entier entre 1 et 5"
                ));
            return $response;
        }
        else if($annee < 1 || $annee > 5) {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes,
                'erreur' => "Champ Année incorrect, veuillez rentrer un entier entre 1 et 5"
                ));
            return $response;
        }
        if ($cours_name == "") {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes,
                'erreur' => "Champ Nom du cours incorrect"
                ));
            return $response;
        }
        else if(Cours::nomCoursExist($cours_name)) {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes,
                'erreur' => "Champ Nom du cours incorrect, ce cours existe déjà"
                ));
            return $response;
        }
        $groupe = Groupe::getGroupeByName($groupe_name);
        Cours::ajouterCours($professeur->user_id, $cours_name, $annee, $groupe->groupe_id);
        $response->redirect('admin', 'ajouterSupprimerCours');
        return $response;
    }
    
    public function supprimerCoursAction()
    {
        $response = new Response();
        $nomCours = $this->request->getPostValue('nomCours');
        $cours_name = $this->request->getPostValue('cours_name');
        if ($cours_name != "") {
            if (!Cours::nomCoursExist($cours_name)) {
                $cours = Cours::getCours();
                $professeurs = User::getProfesseurs();
                $groupes = Groupe::getListeGroupes();
                $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes,
                'erreur' => "Champ Nom du cours incorrect, ce cours n'existe pas"
                ));
                return $response;
            }
            Cours::supprimerCoursByName($cours_name);
        }
        else {
            Cours::supprimerCoursByName($nomCours);
        }
        $response->redirect('admin', 'ajouterSupprimerCours');
        return $response;
    }
    
    public function modificationPromotionAction()
    {
        $response = new Response();
        $promotion = $this->request->getPostValue('promotion');
        $annee = $this->request->getPostValue('annee');
        $supprimer = $this->request->getPostValue('supprimer');
        if ($promotion == "" || ($promotion != "" && !User::promotionExiste($promotion))) {
            $users = User::getUsers();
            $groupes = Groupe::getListeGroupes();
            $this->view->render('admin/listeUsers', array(
                'users' => $users, 
                'erreur' => 'Erreur de saisi dans le champs promotion',
                'groupes' => $groupes
                ));
            return $response;
        }
        if ($supprimer == "Oui") {
            $users = User::getUsersByPromotion($promotion);
            foreach ($users as $user) {
                Proposition_Reponse::supprimerPropositionReponseByUser($user->user_id);
                Participant::supprimerParticipantsByUser($user->user_id);
                User_Groupe::supprimerUserGroupeByUserId($user->user_id);
            }
            User::supprimerPromotion($promotion);
        }
        else {
            User::modifierAnneeByPromotion($annee, $promotion);
        }
        $response->redirect('admin');
        return $response;
    }
    
    public function ajouterGroupeAction()
    {
        $groupe_name = $this->request->getPostValue('groupe_name');
        $groupes = Groupe::getListeGroupes();
        $users = User::getUsers();
        $ok = true;
        foreach ($groupes as $groupe) {
            if ($groupe->groupe_name == $groupe_name) {
                $ok = false;
                break;
            }
        }
        if ($ok) {
            Groupe::ajouterGroupe($groupe_name);
            $groupes = Groupe::getListeGroupes();
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes
            ));
            return new Response();
        }
        $this->view->render('admin/listeUsers', array(
            'users' => $users,
            'groupes' => $groupes,
            'erreur' => "Ce nom de groupe existe déjà."
        ));
        return new Response();
    }
    
    public function supprimerGroupeAction()
    {
        $groupe_name = $this->request->getPostValue('groupe_name');
        $groupe = Groupe::getGroupeByName($groupe_name);
        Groupe::supprimerGroupe($groupe->groupe_id);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        $this->view->render('admin/listeUsers', array(
            'users' => $users,
            'groupes' => $groupes
        ));
        return new Response();
    }
    
    public function AjouterSupprimerUserUnGroupeAction()
    {
        $login = $this->request->getPostValue('login');
        $groupe_name = $this->request->getPostValue('groupe_name');
        $mode = $this->request->getPostValue('mode');
        $groupes = Groupe::getListeGroupes();
        $groupe = Groupe::getGroupeByName($groupe_name);
        $users = User::getUsersByGroupeId($groupe->groupe_id);
        $ok = true;
        
        if ($mode == "Ajouter") {
            foreach ($users as $user) {
                if ($user->login == $login) {
                    $ok = false;
                    break;
                }
            }
            $users = User::getUsers();
            if ($ok) {
                $user = User::getUserByLogin($login);
                User_Groupe::ajouterUserGroupe($user->user_id, $groupe->groupe_id);
                $this->view->render('admin/listeUsers', array(
                    'users' => $users,
                    'groupes' => $groupes
                ));
                return new Response();
            }
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes,
                'erreur' => "Cet utilisateur appartient déjà à ce groupe."
            ));
            return new Response();
        }
        
        else {
            foreach ($users as $user) {
                if ($user->login == $login) {
                    $ok = false;
                    break;
                }
            }
            $users = User::getUsers();
            if ($ok) {
                $this->view->render('admin/listeUsers', array(
                    'users' => $users,
                    'groupes' => $groupes,
                    'erreur' => "Cet utilisateur n'appartient pas à ce groupe."
                ));
                return new Response();
            }
            $user = User::getUserByLogin($login);
            User_Groupe::supprimerUserGroupeByUserId($user->user_id);
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes
            ));
            return new Response();
        }
    }
    
    public function viderGroupeAction()
    {
        $groupe_name = $this->request->getPostValue('groupe_name');
        $groupe = Groupe::getGroupeByName($groupe_name);
        User_Groupe::supprimerUserGroupeByGroupeId($groupe->groupe_id);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        $this->view->render('admin/listeUsers', array(
            'users' => $users,
            'groupes' => $groupes
        ));
        return new Response();
    }
    
    public function transfererGroupeAction()
    {
        $groupe_name_origine = $this->request->getPostValue('groupe_name_origine');
        $groupe_name_destination = $this->request->getPostValue('groupe_name_destination');
        $groupe_origine = Groupe::getGroupeByName($groupe_name_origine);
        $groupe_destination = Groupe::getGroupeByName($groupe_name_destination);
        $users = User::getUsersByGroupeId($groupe_origine->groupe_id);
        foreach ($users as $user) {
            User_Groupe::ajouterUserGroupe($user->user_id, $groupe_destination->groupe_id);
        }
        User_Groupe::supprimerUserGroupeByGroupeId($groupe_origine->groupe_id);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        $this->view->render('admin/listeUsers', array(
            'users' => $users,
            'groupes' => $groupes
        ));
        return new Response();
    }
    
    public function genererRapportGroupeAction()
    {
        $groupe_name = $this->request->getPostValue('groupe_name');
        $groupe = Groupe::getGroupeByName($groupe_name);
        $users = User::getUsersByGroupeId($groupe->groupe_id);
        $this->view->render('admin/rapportGroupe', array(
            'users' => $users,
            'groupe_name' => $groupe_name
        ));
        return new Response();
    }
    
    public function selectionnerCoursAction()
    {
        $cours_name = $this->request->getPostValue('cours_name');
        $cours = Cours::getCoursByName($cours_name);
        $professeur = User::getProfesseurByCours($cours->cours_id);
        $groupe = Groupe::getGroupeById($cours->groupe_id);
        $professeurs = User::getProfesseurs();
        $groupes = Groupe::getListeGroupes();
        $this->view->render('admin/modifierCours', array(
            'cours' => $cours,
            'groupe' => $groupe,
            'groupes' => $groupes,
            'professeurs' => $professeurs,
            'professeur' => $professeur
        ));
        return new Response();
    }
    
    public function modifierCoursAction($cours_name_actuel)
    {
        $cours_name_actuel = str_replace('_', ' ', $cours_name_actuel);
        $cours = Cours::getCoursByName($cours_name_actuel);
        $cours_name = $this->request->getPostValue('cours_name');
        $annee = $this->request->getPostValue('annee');
        $groupe_name = $this->request->getPostValue('groupe_name');
        $professeur_name = $this->request->getPostValue('professeur_name');
        
        if (Cours::nomCoursExist($cours_name)) {
            $professeur = User::getProfesseurByCours($cours->cours_id);
            $groupe = Groupe::getGroupeById($cours->groupe_id);
            $professeurs = User::getProfesseurs();
            $groupes = Groupe::getListeGroupes();
            $this->view->render('admin/modifierCours', array(
                'cours' => $cours,
                'groupe' => $groupe,
                'groupes' => $groupes,
                'professeurs' => $professeurs,
                'professeur' => $professeur,
                'erreur' => "Ce nom de cours existe déjà."
            ));
            return new Response();
        }
        if ($cours_name == '') {
            $cours_name = $cours_name_actuel;
        }
        if ($annee != '' && (!is_int((int)$annee) || $annee > 5)) {
            $professeur = User::getProfesseurByCours($cours->cours_id);
            $groupe = Groupe::getGroupeById($cours->groupe_id);
            $professeurs = User::getProfesseurs();
            $groupes = Groupe::getListeGroupes();
            $this->view->render('admin/modifierCours', array(
                'cours' => $cours,
                'groupe' => $groupe,
                'groupes' => $groupes,
                'professeurs' => $professeurs,
                'professeur' => $professeur,
                'erreur' => "Champs année incorrecte, veuillez saisir un entier entre 1 et 5."
            ));
            return new Response();
        }
        if ($annee == '') {
            $annee = $cours->annee;
        }
        $professeur = User::getUserByLogin($professeur_name);
        $groupe = Groupe::getGroupeByName($groupe_name);
        Cours::miseAJourCoursById($cours->cours_id, $cours_name, $professeur->user_id, $annee, $groupe->groupe_id);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        $this->view->render('admin/listeUsers', array(
            'users' => $users,
            'groupes' => $groupes
        ));
        return new Response();
    }
    
    public function ajouterUserExcelAction()
    {
        move_uploaded_file($_FILES['excel']['tmp_name'],$_FILES['excel']['name']);
        $this->lectureFichierAjouterUser(__ROOT_DIR__ . '\\' . $_FILES['excel']['name']);
        unlink($_FILES['excel']['name']);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        if ($this->erreur != "") {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes,
                'erreur' => $this->erreur
            ));
        }
        else {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes
            ));
        }
        return new Response();
    }
    
    public function supprimerUserExcelAction()
    {
        move_uploaded_file($_FILES['excel']['tmp_name'],$_FILES['excel']['name']);
        $this->lectureFichierSupprimerUser(__ROOT_DIR__ . '\\' . $_FILES['excel']['name']);
        unlink($_FILES['excel']['name']);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        if ($this->erreur != "") {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes,
                'erreur' => $this->erreur
            ));
        }
        else {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes
            ));
        }
        return new Response();
    }
    
    public function ajouterGroupeExcelAction()
    {
        move_uploaded_file($_FILES['excel']['tmp_name'],$_FILES['excel']['name']);
        $this->lectureFichierAjouterGroupe(__ROOT_DIR__ . '\\' . $_FILES['excel']['name']);
        unlink($_FILES['excel']['name']);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        if ($this->erreur != "") {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes,
                'erreur' => $this->erreur
            ));
        }
        else {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes
            ));
        }
        return new Response();
    }
    
    public function supprimerGroupeExcelAction()
    {
        move_uploaded_file($_FILES['excel']['tmp_name'],$_FILES['excel']['name']);
        $this->lectureFichierSupprimerGroupe(__ROOT_DIR__ . '\\' . $_FILES['excel']['name']);
        unlink($_FILES['excel']['name']);
        $users = User::getUsers();
        $groupes = Groupe::getListeGroupes();
        if ($this->erreur != "") {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes,
                'erreur' => $this->erreur
            ));
        }
        else {
            $this->view->render('admin/listeUsers', array(
                'users' => $users,
                'groupes' => $groupes
            ));
        }
        return new Response();
    }
    
    public function supprimerCoursExcelAction()
    {
        move_uploaded_file($_FILES['excel']['tmp_name'],$_FILES['excel']['name']);
        $this->lectureFichierSupprimerCours(__ROOT_DIR__ . '\\' . $_FILES['excel']['name']);
        unlink($_FILES['excel']['name']);
        $cours = Cours::getCours();
        $professeurs = User::getProfesseurs();
        $groupes = Groupe::getListeGroupes();
        if ($this->erreur != "") {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes,
                'erreur' => $this->erreur
            ));
        }
        else {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes
            ));
        }
        return new Response();
    }
    
    public function ajouterCoursExcelAction()
    {
        move_uploaded_file($_FILES['excel']['tmp_name'],$_FILES['excel']['name']);
        $this->lectureFichierAjouterCours(__ROOT_DIR__ . '\\' . $_FILES['excel']['name']);
        unlink($_FILES['excel']['name']);
        $cours = Cours::getCours();
        $professeurs = User::getProfesseurs();
        $groupes = Groupe::getListeGroupes();
        if ($this->erreur != "") {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes,
                'erreur' => $this->erreur
            ));
        }
        else {
            $this->view->render('admin/listeCoursAdmin',array(
                'cours' => $cours, 
                'professeurs' => $professeurs,
                'groupes' => $groupes
            ));
        }
        return new Response();
    }
    
    
    
    
    
    
    //TRAITEMENT DES FICHIERS EXCEL
    
    private $erreur;
    private $data;
    private $dataEnTetePositionnement;
    private $stop;
    
    public function lectureFichierAjouterUser($name)
    {
        $this->erreur = "";
        $this->data = new Spreadsheet_Excel_Reader();
        $this->data->setOutputEncoding('CP1251');
        $this->data->read($name);
        
        $this->stop = $this->setDataEnTeteAjouterUser();
        
        if (!$this->stop) {
            $this->stop = $this->verificationDataEnTeteAjouterUser();
            if (!$this->stop) {
                for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
                    $this->recuperationDataAjouterUser($i);
                }
            }
        }
    }
    
    public function setDataEnTeteAjouterUser()
    {
        $enTeteType = array("login","password","admin","professeur","annee","promotion","groupe");
        $this->dataEnTetePositionnement = array();
        for ($i=0;$i<count($enTeteType);$i++) {
            array_push($this->dataEnTetePositionnement, 0);
        }
        for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
            $ok = false;
            if ($this->data->sheets[0]['cells'][1][$i] == "") {
                break;
            }
            for ($j=0;$j<count($enTeteType);$j++) {
                if ($enTeteType[$j] == $this->data->sheets[0]['cells'][1][$i]) {
                    $this->dataEnTetePositionnement[$j] = $i;
                    $ok = true;
                    break;
                }
            }
            if (!$ok) {
                $this->erreur = "Erreur : En-tête de fichier incorrecte.";
                return true;
            }
        }
        return false;
    }
    
    public function verificationDataEnTeteAjouterUser()
    {
        if ($this->dataEnTetePositionnement[0] == 0 || $this->dataEnTetePositionnement[1] == 0) {
            $this->erreur = "Erreur : données manquantes pour les champs login ou/et password.";
            return true;
        }
        return false;
    }
    
    public function recuperationDataAjouterUser($ligne)
    {
        $login =  $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[0]];
        $password = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[1]];
        
        if ($this->dataEnTetePositionnement[2] == 0) {
            $admin = 0;
        }
        else {
            $admin = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[2]];
        }
        
        if ($this->dataEnTetePositionnement[3] == 0) {
            $professeur = 0;
        }
        else {
            $professeur = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[3]];
        }
        
        if ($this->dataEnTetePositionnement[4] == 0) {
            $annee = "";
        }
        else {
            $annee = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[4]];
        }
        
        if ($this->dataEnTetePositionnement[5] == 0) {
            $promotion = "";
        }
        else {
            $promotion = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[5]];
        }
        
        if ($this->dataEnTetePositionnement[6] == 0) {
            $groupe = "";
        }
        else {
            $groupe = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[6]];
        }
        
        if ($groupe != "" && !Groupe::groupeExiste($groupe)) {
            Groupe::ajouterGroupe($groupe);
        }
        $leGroupe = Groupe::getGroupeByName($groupe);
        $password = sha1($password);
        if (User::isLoginUsed($login)) {
            $user = User::getUserByLogin($login);
            User::miseAJourUser($user->user_id, $password, $professeur, $annee, $admin, $promotion, $leGroupe->groupe_id);
        }
        else {
            User::ajouterUser($login, $password, $admin, $professeur, $annee, $promotion, $leGroupe->groupe_id);
        }
    }
    
    public function lectureFichierSupprimerUser($name)
    {
        $this->erreur = "";
        $this->data = new Spreadsheet_Excel_Reader();
        $this->data->setOutputEncoding('CP1251');
        $this->data->read($name);
        
        $this->dataEnTetePositionnement = 0;
        for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
            $ok = false;
            if ($this->data->sheets[0]['cells'][1][$i] == "") {
                break;
            }
            if ("login" == $this->data->sheets[0]['cells'][1][$i]) {
                $this->dataEnTetePositionnement = $i;
                $ok = true;
                break;
            }
        }
        if (!$ok) {
            $this->erreur = "Erreur : En-tête de fichier incorrecte.";
            $this->stop = true;
        }
        
        if (!$this->stop) {
            for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
                $login = $this->data->sheets[0]['cells'][$i][$this->dataEnTetePositionnement];
                User::supprimerUser($login);
            }
        }
    }
    
    public function lectureFichierAjouterGroupe($name)
    {
        $this->erreur = "";
        $this->data = new Spreadsheet_Excel_Reader();
        $this->data->setOutputEncoding('CP1251');
        $this->data->read($name);
        
        $this->dataEnTetePositionnement = 0;
        for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
            $ok = false;
            if ($this->data->sheets[0]['cells'][1][$i] == "") {
                break;
            }
            if ("groupe" == $this->data->sheets[0]['cells'][1][$i]) {
                $this->dataEnTetePositionnement = $i;
                $ok = true;
                break;
            }
        }
        if (!$ok) {
            $this->erreur = "Erreur : En-tête de fichier incorrecte.";
            $this->stop = true;
        }
        
        if (!$this->stop) {
            for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
                $groupe = $this->data->sheets[0]['cells'][$i][$this->dataEnTetePositionnement];
                Groupe::ajouterGroupe($groupe);
            }
        }
    }
    
    public function lectureFichierSupprimerGroupe($name)
    {
        $this->erreur = "";
        $this->data = new Spreadsheet_Excel_Reader();
        $this->data->setOutputEncoding('CP1251');
        $this->data->read($name);
        
        $this->dataEnTetePositionnement = 0;
        for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
            $ok = false;
            if ($this->data->sheets[0]['cells'][1][$i] == "") {
                break;
            }
            if ("groupe" == $this->data->sheets[0]['cells'][1][$i]) {
                $this->dataEnTetePositionnement = $i;
                $ok = true;
                break;
            }
        }
        if (!$ok) {
            $this->erreur = "Erreur : En-tête de fichier incorrecte.";
            $this->stop = true;
        }
        
        if (!$this->stop) {
            for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
                $groupe = $this->data->sheets[0]['cells'][$i][$this->dataEnTetePositionnement];
                Groupe::supprimerGroupeByName($groupe);
            }
        }
    }
    
    public function lectureFichierSupprimerCours($name)
    {
        $this->erreur = "";
        $this->data = new Spreadsheet_Excel_Reader();
        $this->data->setOutputEncoding('CP1251');
        $this->data->read($name);
        
        $this->dataEnTetePositionnement = 0;
        for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
            $ok = false;
            if ($this->data->sheets[0]['cells'][1][$i] == "") {
                break;
            }
            if ("cours" == $this->data->sheets[0]['cells'][1][$i]) {
                $this->dataEnTetePositionnement = $i;
                $ok = true;
                break;
            }
        }
        if (!$ok) {
            $this->erreur = "Erreur : En-tête de fichier incorrecte.";
            $this->stop = true;
        }
        
        if (!$this->stop) {
            for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
                $cours = $this->data->sheets[0]['cells'][$i][$this->dataEnTetePositionnement];
                Cours::supprimerCoursByName($cours);
            }
        }
    }
    
    
    
    //?.........
    
    public function lectureFichierAjouterCours($name)
    {
        $this->erreur = "";
        $this->data = new Spreadsheet_Excel_Reader();
        $this->data->setOutputEncoding('CP1251');
        $this->data->read($name);
        
        $this->stop = $this->setDataEnTeteAjouterCours();
        
        if (!$this->stop) {
            $this->stop = $this->verificationDataEnTeteAjouterCours();
            if (!$this->stop) {
                for ($i = 2; $i <= $this->data->sheets[0]['numRows']; $i++) {
                    $this->recuperationDataAjouterCours($i);
                }
            }
        }
    }
    
    public function setDataEnTeteAjouterCours()
    {
        $enTeteType = array("cours","annee","groupe","professeur");
        $this->dataEnTetePositionnement = array();
        for ($i=0;$i<count($enTeteType);$i++) {
            array_push($this->dataEnTetePositionnement, 0);
        }
        for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
            $ok = false;
            if ($this->data->sheets[0]['cells'][1][$i] == "") {
                break;
            }
            for ($j=0;$j<count($enTeteType);$j++) {
                if ($enTeteType[$j] == $this->data->sheets[0]['cells'][1][$i]) {
                    $this->dataEnTetePositionnement[$j] = $i;
                    $ok = true;
                    break;
                }
            }
            if (!$ok) {
                $this->erreur = "Erreur : En-tête de fichier incorrecte.";
                return true;
            }
        }
        return false;
    }
    
    public function verificationDataEnTeteAjouterCours()
    {
        if ($this->dataEnTetePositionnement[0] == 0 || $this->dataEnTetePositionnement[1] == 0 || $this->dataEnTetePositionnement[2] == 0 || $this->dataEnTetePositionnement[3] == 0) {
            $this->erreur = "Erreur : données manquantes pour les champs login ou/et password.";
            return true;
        }
        return false;
    }
    
    public function recuperationDataAjouterCours($ligne)
    {
        $cours_name = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[0]];
        $annee = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[1]];
        $groupe_name = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[2]];
        $professeur = $this->data->sheets[0]['cells'][$ligne][$this->dataEnTetePositionnement[3]];
        if (User::isLoginUsed($professeur)) {
            $user = User::getUserByLogin($professeur);
            if (!Groupe::groupeExiste($groupe_name)) {
                Groupe::ajouterGroupe($groupe_name);
            }
            $groupe = Groupe::getGroupeByName($groupe_name);
            if (Cours::nomCoursExist($cours_name)) {
                $cours = Cours::getCoursByName($cours_name);
                Cours::miseAJourCoursById($cours->cours_id, $cours_name, $user->user_id, $annee, $groupe->groupe_id);
            }
            else {
                Cours::ajouterCours($user->user_id, $cours_name, $annee, $groupe->groupe_id);
            }
        }
    }
    
    
}