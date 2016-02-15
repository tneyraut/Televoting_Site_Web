<?php $nomCours = str_replace(' ', '_', $nomCours); ?>

<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#modifierQuestionnaire" aria-controls="modifierQuestionnaire" role="tab" data-toggle="tab">Modifier / Supprimer / Réinitialiser un questionnaire</a></li>
            <li role="presentation"><a href="#creerQuestionnaire" aria-controls="creerQuestionnaire" role="tab" data-toggle="tab">Créer un questionnaire</a></li>
            <li role="presentation"><a href="#selectCours" aria-controls="selectCours" role="tab" data-toggle="tab">Sélectionner un autre cours</a></li>
        </ul>
        <br><br>
        <div class="tab-content">
            <?php if (isset($erreur)): ?>
                <div class="alert alert-danger" role="alert"><?php echo $erreur ?></div>
            <?php endif ?>
            <div role="tabpanel" class="tab-pane fade in active" id="modifierQuestionnaire">
                <div class="panel-body">
                    <?php if (count($questionnaires) == 0): ?>
                    <strong>
                        Vous n'avez aucun questionnaire créé.
                    </strong>
                    <?php else: ?>
                        <form action="<?php echo $this->bu('questionnaire','listeQuestion',array('nomCours' => $nomCours)); ?>" method="post">
                            <table>
                                <tr>
                                    <th>Sélectionner un questionnaire :</th>
                                    <td>
                                        <select name="nomQuestionnaire" class="selectpicker show-tick form-control">
                                            <?php foreach($questionnaires as $unQuestionnaire): ?>
                                            <option><?php echo $unQuestionnaire->questionnaire_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Supprimer le questionnaire :</th>
                                    <td>
                                        <select name="suppression" class="selectpicker show-tick form-control">
                                            <option>Non</option>
                                            <option>Oui</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Réinitialiser le questionnaire :</th>
                                    <td>
                                        <select name="reinitialisation" class="selectpicker show-tick form-control">
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
            
            <div role="tabpanel" class="tab-pane fade" id="creerQuestionnaire">
                <div class="panel-body">
                    <form action="<?php echo $this->bu('questionnaire','ajouterQuestionnaire', array('nomCours' => $nomCours)); ?>" method="post">
                        <table>
                            <tr>
                                <th>Nom du questionnaire :</th>
                                <td><input type="text" placeholder="Rentrer le nom du questionnaire" class="input-control form-control" name="questionnaire_name"></td>
                            </tr>
                            <tr>
                                <th>Mode examen :</th>
                                <td>
                                    <select name="mode_examen" class="selectpicker show-tick form-control">
                                        <option>Non</option>
                                        <option>Oui</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Malus :</th>
                                <td><input type="text" placeholder="Rentrer un nombre positif" class="input-control form-control" name="malus"></td>
                            </tr>
                            <tr>
                                <th>Mode Pause :</th>
                                <td>
                                    <select name="pause" class="selectpicker show-tick form-control">
                                        <option>Oui</option>
                                        <option>Non</option>
                                    </select>
                                </td>
                            </tr>
                        </table><br>
                        <button id="btn-valider-modification" type="submit" class="btn btn-primary btn-lg center">Créer le questionnaire</button>
                    </form>
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="selectCours">
                <div class="panel-body">
                    <form action="<?php echo $this->bu('questionnaire', 'listeQuestionnaires'); ?>" method="post">
                        <table>
                            <tr>
                                <th>Sélectionner un cours :</th>
                                <td>
                                    <select name="nomCours" class="selectpicker show-tick form-control">
                                        <?php foreach ($cours as $unCours): ?>
                                            <option><?php echo $unCours->cours_name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </table><br>
                        <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
    
</section>