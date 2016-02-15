<?php
$cours_name = str_replace(' ', '_', $cours_name);
$questionnaire_name = str_replace(' ', '_', $questionnaire_name);
?>

<section class="panel panel-default content">
    
    <div class="panel-heading">
        <h2 class="panel-title">Confirmation lancement du questionnaire : <?php echo str_replace('_', ' ', $questionnaire_name); ?> ; du cours : <?php echo str_replace('_', ' ', $cours_name); ?></h2>
    </div>
    
    <div class="panel-body">
        <?php $tempsImparti = false;
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
        </table><br>
        <?php endif; ?>
        <?php if (count($questions) != 0): ?>
        <form action="<?php echo $this->bu('eleve', 'lancerQuestionnaire', array('cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
            <table>
                <tr>
                    <th>Attention : une fois le questionnaire lancé, vous devrez le réaliser d'un seul trait.</th>
                </tr>
            </table><br>
            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Répondre au questionnaire</button>
        </form>
        <?php else: ?>
        <table>
            <tr>
                <th>Ce questionnaire ne contient aucune question / Vous avez déjà répondu à ce questionnaire</th>
            </tr>
        </table><br>
        <?php endif; ?>
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