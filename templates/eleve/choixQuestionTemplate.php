<?php
$cours_name = str_replace(' ', '_', $cours_name);
$questionnaire_name = str_replace(' ', '_', $questionnaire_name);
?>

<section class="panel panel-default content">
    
    <div class="panel-heading">
        <h2 class="panel-title">Liste des questions relatives au questionnaire : <?php echo str_replace('_', ' ', $questionnaire_name); ?> ; du cours : <?php echo str_replace('_', ' ', $cours_name); ?></h2>
    </div>
    
    <?php if (isset($erreur)): ?>
        <div class="alert alert-danger" role="alert"><?php echo $erreur; ?></div>
    <?php endif ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert"><?php echo $success; ?></div>
    <?php endif ?>
    
    <div class="panel-body">
        <?php if (count($questions) == 0): ?>
        <strong>
            Ce questionnaire ne contient aucune question / Vous avez déjà répondu à ce questionnaire
        </strong>
        <?php else: 
            $tempsImparti = false;
            foreach ($questions as $uneQuestion):
                if ($uneQuestion->temps_imparti > 0):
                    $tempsImparti = true;
                    break;
                endif;
            endforeach;
            if ($tempsImparti): ?>
            <table>
                <tr>
                    <th>Attention : ce questionnaire contient des questions avec temps imparti.</th>
                </tr>
            </table>
        <?php endif; ?>
            <form action="<?php echo $this->bu('eleve','repondre',array('cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                <table>
                    <tr>
                        <th>Sélectionner une question : Question numéro</th>
                        <td>
                            <select name="question_id" class="selectpicker show-tick form-control">
                                <?php foreach($questions as $uneQuestion): ?>
                                <option><?php echo $uneQuestion->question_id; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table><br>
                <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Répondre à la question</button>
            </form>
        <?php endif ?>
    </div>
    
    <div class="panel-heading">
        <h2 class="panel-title">Sélectionner un autre questionnaire</h2>
    </div>
    <div class="panel-body">
        <form action="<?php echo $this->bu('eleve', 'choixQuestion', array('cours_name' => $cours_name)); ?>" method="post">
            <table>
                <tr>
                    <th>Sélectionner un questionnaire :</th>
                    <td>
                        <select name="nomQuestionnaire" class="selectpicker show-tick form-control">
                            <?php foreach ($questionnaires as $unQuestionnaire): ?>
                                <option><?php echo $unQuestionnaire->questionnaire_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table><br>
            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Répondre au questionnaire</button>
        </form>
    </div>
    
</section>