<?php 
$cours_name = $leCours->cours_name; 
$cours_name = str_replace(' ', '_', $cours_name);
?>

<section class="panel panel-default content">
    
    <div class="panel-heading">
        <h2 class="panel-title">Sélection d'un questionnaire du cours : <?php echo str_replace('_', ' ', $cours_name);; ?></h2>
    </div>
    <div class="panel-body">
        <?php if (count($questionnaires) == 0): ?>
        <strong>
            Vous n'avez aucun questionnaire créé.
        </strong>
        <?php else: ?>
            <form action="<?php echo $this->bu('statistique', 'statistiqueQuestionnaire', array('nomCours' => $cours_name)); ?>" method="post">
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
                </table><br>
                <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>
            </form>
        <?php endif ?>
    </div>
    
    <div class="panel-heading">
        <h2 class="panel-title">Sélection d'un autre cours enseigné</h2>
    </div>
    <div class="panel-body">
        <form action="<?php echo $this->bu('statistique', 'statChoixQuestionnaire'); ?>" method="post">
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
    
</section>