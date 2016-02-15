<?php 
$cours_name = str_replace(' ', '_', $cours_name);
$questionnaire_name = str_replace(' ', '_', $questionnaire_name);
?>

<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#modifierQuestion" aria-controls="modifierQuestion" role="tab" data-toggle="tab">Modifier la question</a></li>
            <li role="presentation"><a href="#listeReponses" aria-controls="listeReponses" role="tab" data-toggle="tab">Liste des réponses</a></li>
            <li role="presentation"><a href="#ajouterReponse" aria-controls="ajouterReponse" role="tab" data-toggle="tab">Ajouter une réponse</a></li>
            <li role="presentation"><a href="#listeQuestions" aria-controls="listeQuestions" role="tab" data-toggle="tab">Modifier une question du questionnaire</a></li>
            <li role="presentation"><a href="#creerQuestion" aria-controls="creerQuestion" role="tab" data-toggle="tab">Créer une question</a></li>
        </ul>
        <br><br>
        <div class="tab-content">
            <?php if (isset($erreur)): ?>
                <div class="alert alert-danger" role="alert"><?php echo $erreur ?></div>
            <?php endif ?>
                
            <div role="tabpanel" class="tab-pane fade in active" id="modifierQuestion">
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="<?php echo $this->bu('questionnaire','modificationQuestion',array('question_id' => $question->question_id, 'cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                        <table>
                            <tr>
                                <th>Question actuelle :</th>
                                <td><?php echo $question->question; ?></td>
                            </tr>
                            <tr>
                                <th>Modifier la question :</th>
                                <td><input type="text" placeholder="Modifier la question" class="input-control form-control" name="question_contenu"></td>
                            </tr>
                            <tr>
                                <th>Temps imparti actuel :</th>
                                <td><?php echo $question->temps_imparti; ?></td>
                            </tr>
                            <tr>
                                <th>Modifier le temps imparti :</th>
                                <td><input type="text" placeholder="Modifier le temps imparti" class="input-control form-control" name="temps_imparti"></td>
                            </tr>
                            <tr>
                                <th>Image actuelle :</th>
                                <td><?php if ($question->image == NULL): echo "Aucune image enregistrée"; else: ?><img class="imageUpload" src="<?php echo $this->bu().$question->image; ?>"/><?php endif; ?></td>
                            </tr>
                            <tr>
                                <th>Changer / Ajouter une image :</th>
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                <td><input type="file" class="btn btn-default" name="image" id="image" /></td>
                            </tr>
                            <?php if ($question->image != NULL): ?>
                            <tr>
                                <th>Supprimer l'image :</th>
                                <td>
                                    <select name="supprimer_image" class="selectpicker show-tick form-control">
                                        <option>Non</option>
                                        <option>Oui</option>
                                    </select>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </table><br>
                        <button id="btn-valider-modification" type="submit" class="btn btn-primary btn-lg center">Valider les modifications</button><br>
                    </form>
                </div>
            </div>
                
            <div role="tabpanel" class="tab-pane fade" id="listeReponses">
                <div class="panel-body">
                    <?php if ($reponses == NULL): ?>
                        <strong>Cette question ne comporte actuellement aucune réponse.</strong>
                    <?php else : foreach ($reponses as $reponse): ?>
                        <form enctype="multipart/form-data" action="<?php echo $this->bu('questionnaire','modificationReponse',array('question_id' => $question->question_id, 'reponse_id' => $reponse->reponse_id, 'cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                            <table>
                                <tr>
                                    <th>Réponse actuelle :</th>
                                    <td><?php echo $reponse->reponse; ?></td>
                                </tr>
                                <tr>
                                    <th>Modifier la réponse :</th>
                                    <td><input type="text" placeholder="Modifier la réponse" class="input-control form-control" name="reponse_contenu"></td>
                                </tr>
                                <tr>
                                    <th>Réponse correcte actuellement :</th>
                                    <td><?php if($reponse->reponse_correcte == 1): echo "Oui"; else : echo "Non"; endif; ?></td>
                                </tr>
                                <tr>
                                    <th>Modifier :</th>
                                    <td>
                                        <select name="reponse_correcte" class="selectpicker show-tick form-control">
                                            <option><?php if ($reponse->reponse_correcte == 1): ?>Oui<?php else: ?>Non<?php endif; ?></option>
                                            <option><?php if ($reponse->reponse_correcte == 1): ?>Non<?php else: ?>Oui<?php endif; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Image actuelle :</th>
                                    <td><?php if ($reponse->image == NULL): echo "Aucune image enregistrée"; else: ?><img class="imageUpload" src="<?php echo $this->bu().$reponse->image; ?>"/><?php endif; ?></td>
                                </tr>
                                <tr>
                                    <th>Changer / Ajouter une image :</th>
                                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                    <td><input type="file" class="btn btn-default" name="image" id="image" /></td>
                                </tr>
                                <?php if ($reponse->image != NULL): ?>
                                <tr>
                                    <th>Supprimer l'image :</th>
                                    <td>
                                        <select name="supprimer_image" class="selectpicker show-tick form-control">
                                            <option>Non</option>
                                            <option>Oui</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Supprimer la réponse :</th>
                                    <td>
                                        <select name="suppression" class="selectpicker show-tick form-control">
                                            <option>Non</option>
                                            <option>Oui</option>
                                        </select>
                                    </td>
                                </tr>
                            </table><br>
                            <button id="btn-valider-modification" type="submit" class="btn btn-primary btn-lg center">Valider les modifications</button><br><br>
                        </form>
                    <?php endforeach; endif; ?>
                </div>
            </div>
                
            <div role="tabpanel" class="tab-pane fade" id="ajouterReponse">
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="<?php echo $this->bu('questionnaire','ajouterReponse',array('question_id' => $question->question_id, 'cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                        <table>
                            <tr>
                                <th>Nouvelle réponse :</th>
                                <td><input type="text" placeholder="Rentrer une nouvelle réponse" class="input-control form-control" name="nouvelle_reponse"></td>
                            </tr>
                            <tr>
                                <th>Réponse correcte :</th>
                                <td>
                                    <select name="nouvelle_reponse_correcte" class="selectpicker show-tick form-control">
                                        <option>Oui</option>
                                        <option>Non</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Ajouter une image :</th>
                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                <td><input type="file" class="btn btn-default" name="image" id="image" /></td>
                            </tr>
                        </table><br>
                        <button id="btn-valider-modification" type="submit" class="btn btn-primary btn-lg center">Ajouter la réponse</button>
                    </form>
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
                
        </div>
    </div>
    
</section>