<?php 
$cours_name = $questionnaire->cours_name;
$questionnaire_name = $questionnaire->questionnaire_name;
$cours_name = str_replace(' ', '_', $cours_name);
$questionnaire_name = str_replace(' ', '_', $questionnaire_name);
?>

<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#infosGenerales" aria-controls="infosGenerales" role="tab" data-toggle="tab">Informations générales du questionnaire</a></li>
            <li role="presentation"><a href="#listeQuestions" aria-controls="listeQuestions" role="tab" data-toggle="tab">Modifier une question du questionnaire</a></li>
            <li role="presentation"><a href="#creerQuestion" aria-controls="creerQuestion" role="tab" data-toggle="tab">Créer une question</a></li>
            <li role="presentation"><a href="#apercuPartielQuestionnaire" aria-controls="apercuPartielQuestionnaire" role="tab" data-toggle="tab">Aperçu partiel du questionnaire</a></li>
            <li role="presentation"><a href="#apercuTotalQuestionnaire" aria-controls="apercuTotalQuestionnaire" role="tab" data-toggle="tab">Aperçu total du questionnaire</a></li>
        </ul>
        <br><br>
        <div class="tab-content">
            
            <?php if (isset($erreur)): ?>
                <div class="alert alert-danger" role="alert"><?php echo $erreur ?></div>
            <?php endif ?>
                
            <div role="tabpanel" class="tab-pane fade in active" id="infosGenerales">
                <div class="panel-body">
                    <?php if (!isset($questionnaire)): ?>
                    <strong>
                        ERREUR : Veuillez contacter l'administrateur par mail thomas.neyraut@minesdedouai.fr.
                    </strong>
                    <?php else: ?>
                        <form action="<?php echo $this->bu('questionnaire','modificationQuestionnaire',array('cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                            <table>
                                <tr>
                                    <th>Nom du cours :</th>
                                    <td><?php echo $questionnaire->cours_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Modifier le cours auquel le questionnaire est rattaché :</th>
                                    <td>
                                        <select name="nomCours" class="selectpicker show-tick form-control">
                                            <?php foreach($cours as $unCours): ?>
                                            <option><?php echo $unCours->cours_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nom du questionnaire :</th>
                                    <td><?php echo $questionnaire->questionnaire_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Modifier le nom du questionnaire :</th>
                                    <td><input type="text" placeholder="Modifier le nom du questionnaire" class="input-control form-control" name="nomQuestionnaire"></td>
                                </tr>
                                <tr>
                                    <th>Mode examen :</th>
                                    <td>
                                        <?php if ($questionnaire->mode_examen == 1): echo 'Oui'; else: echo 'Non'; endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Changer de mode :</th>
                                    <td>
                                        <select name="modeExamen" class="selectpicker show-tick form-control">
                                            <option><?php if ($questionnaire->mode_examen == 1): echo 'Oui'; else: echo 'Non'; endif; ?></option>
                                            <option><?php if ($questionnaire->mode_examen == 1): echo 'Non'; else: echo 'Oui'; endif; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Malus actuel :</th>
                                    <td>
                                        <?php echo $questionnaire->malus; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Changer Malus :</th>
                                    <td><input type="text" placeholder="Modifier malus, un nombre positif" class="input-control form-control" name="malus"></td>
                                </tr>
                                <tr>
                                    <th>Pause durant le questionnaire :</th>
                                    <td>
                                        <?php if ($questionnaire->pause == 1): echo 'Oui'; else: echo 'Non'; endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Changer le mode pause :</th>
                                    <td>
                                        <select name="pause" class="selectpicker show-tick form-control">
                                            <option><?php if ($questionnaire->pause == 1): echo 'Oui'; else: echo 'Non'; endif; ?></option>
                                            <option><?php if ($questionnaire->pause == 1): echo 'Non'; else: echo 'Oui'; endif; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Questionnaire lancé :</th>
                                    <td><?php if($questionnaire->lancee == 1): echo "Oui"; else: echo "Non"; endif; ?></td>
                                </tr>
                                <tr>
                                    <th>Changement questionnaire lancé :</th>
                                    <td>
                                        <select name="lancee" class="selectpicker show-tick form-control">
                                            <option><?php if($questionnaire->lancee == 1): echo "Oui"; else: echo "Non"; endif; ?></option>
                                            <option><?php if($questionnaire->lancee == 1): echo "Non"; else: echo "Oui"; endif; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Barême note et nombre de bonnes réponses :</th>
                                    <td><?php echo "/ ".$bareme; ?></td>
                                </tr>
                                <tr>
                                    <th>Barême nombre de mauvaises réponses :</th>
                                    <td><?php echo "/ ".$baremeFautes; ?></td>
                                </tr>
                            </table><br>
                            <button id="btn-valider-modification" type="submit" class="btn btn-primary btn-lg center">Valider les modifications</button>
                        </form>
                    <?php endif ?>
                </div>
            </div>
                
            <div role="tabpanel" class="tab-pane fade" id="listeQuestions">
                <div class="panel-body">
                    <?php if (count($questions) == 0): ?>
                    <strong>
                        Vous n'avez aucune question pour ce questionnaire.
                    </strong>
                    <?php else: ?>
                        <form action="<?php echo $this->bu('questionnaire','selectionQuestion',array('nomCours' => $cours_name, 'nomQuestionnaire' => $questionnaire_name)); ?>" method="post">
                            <table>
                                <tr>
                                    <th>Sélectionner une question :</th>
                                    <td>
                                        <select name="nomQuestion" class="selectpicker show-tick form-control">
                                            <?php foreach($questions as $uneQuestion): ?>
                                            <option><?php echo $uneQuestion->question; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Supprimer la question :</th>
                                    <td>
                                        <select name="suppression" class="selectpicker show-tick form-control">
                                            <option>Non</option>
                                            <option>Oui</option>
                                        </select>
                                    </td>
                                </tr>
                            </table><br>
                            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>
                        </form>
                    <?php endif ?>
                </div>
            </div>
                
            <div role="tabpanel" class="tab-pane fade" id="creerQuestion">
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="<?php echo $this->bu('questionnaire','ajouterQuestion',array('cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                        <table>
                            <tr>
                                <th>Question :</th>
                                <td><input type="text" placeholder="Rentrer la nouvelle question" class="input-control form-control" name="question"></td>
                            </tr>
                            <tr>
                                <th>Temps imparti :</th>
                                <td><input type="text" placeholder="Rentrer un temps en seconde si nécessaire" class="input-control form-control" name="temps_imparti"></td>
                            </tr>
                            <tr>
                                <th>Image :</th>
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                <td><input type="file" class="btn btn-default" name="image" id="image" /></td>
                            </tr>
                        </table><br>
                        <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Créer la question</button>
                    </form>
                </div>
            </div>
                
            <div role="tabpanel" class="tab-pane fade" id="apercuPartielQuestionnaire">
                <div class="panel-body">
                    <?php if (count($questions) == 0): ?>
                    <strong>
                        Ce questionnaire ne comporte aucune question.
                    </strong>
                    <?php else: ?>
                    <?php foreach ($questions as $question): $existReponse = false; ?>
                    <table>
                        <tr>
                            <th>Question : </th>
                            <td><?php echo $question->question; ?></td>
                        </tr>
                        <tr>
                            <th>Reponses : </th>
                        </tr>
                        <?php foreach ($reponses as $reponse): if($reponse->question_id == $question->question_id): $existReponse = true; ?>
                        <tr>
                            <td><?php echo $reponse->reponse; ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; if(!$existReponse): ?>
                        <tr>
                            <th>Cette question ne comporte aucune réponse.</th>
                        </tr>
                        <?php endif; ?>
                    </table>
                    <br><br>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
                
                
            <div role="tabpanel" class="tab-pane fade" id="apercuTotalQuestionnaire">
                <div class="panel-body">
                    <?php if (count($questions) == 0): ?>
                    <strong>
                        Ce questionnaire ne comporte aucune question.
                    </strong>
                    <?php else: ?>
                    <?php foreach ($questions as $question): $existReponse = false; ?>
                    <table>
                        <tr>
                            <th>Question : <?php echo $question->question ?></th>
                            <td>Temps imparti : <?php echo $question->temps_imparti." secondes"; ?></td>
                        </tr>
                        <tr>
                            <th>Reponses : </th>
                        </tr>
                        <?php foreach ($reponses as $reponse): if($reponse->question_id == $question->question_id): $existReponse = true; ?>
                        <tr>
                            <th><?php echo $reponse->reponse; ?></th>
                            <td>Reponse <?php if ($reponse->reponse_correcte == 1): echo "correcte"; else: echo "fausse"; endif; ?></td>
                        </tr>
                        
                        <?php endif; endforeach; if(!$existReponse): ?>
                        <tr>
                            <th>Cette question ne comporte aucune réponse.</th>
                        </tr>
                        <?php endif; ?>
                    </table>
                    <br><br>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
                
        </div>
    </div>
       
</section>