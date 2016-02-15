<?php $cours_name = str_replace(' ', '_', $cours_name); ?>

<section class="panel panel-default content">
    
    <div class="panel-heading">
        <h2 class="panel-title">Résultats du questionnaires</h2>
    </div>
    <div class="panel-body">
        <table>
            <tr>
                <th>Cours :</th>
                <td><?php echo str_replace('_', ' ', $cours_name); ?></td>
            </tr>
            <tr>
                <th>Questionnaire :</th>
                <td><?php echo $nomQuestionnaire; ?></td>
            </tr>
        </table><br>
        <table>
            <tr>
                <th>Vos résultats</th>
            </tr>
            <tr>
                <th>Note :</th>
                <td><?php echo $participant->note." / ".$bareme; ?></td>
            </tr>
            <tr>
                <th>Nombre de bonnes réponses :</th>
                <td><?php echo $participant->nombre_de_bonnes_reponses." / ".$bareme; ?></td>
            </tr>
            <tr>
                <th>Nombre de fautes :</th>
                <td><?php echo $participant->nombre_de_fautes." / ".$baremeFautes; ?></td>
            </tr>
        </table><br>
        <table>
            <tr>
                <th>Résultats généraux</th>
            </tr>
            <tr>
                <th>Moyenne au questionnaire :</th>
                <td><?php echo $moyenneNote." / ".$bareme; ?></td>
            </tr>
            <tr>
                <th>Note maximale obtenue :</th>
                <td><?php echo $maxNote." / ".$bareme; ?></td>
            </tr>
            <tr>
                <th>Note minimale obtenue :</th>
                <td><?php echo $minNote." / ".$bareme; ?></td>
            </tr>
            <tr>
                <th>Nombre moyen de bonnes réponses :</th>
                <td><?php echo $moyenneNombreBonnesReponses." / ".$bareme; ?></td>
            </tr>
            <tr>
                <th>Nombre moyen de fautes :</th>
                <td><?php echo $moyenneNombreFautes." / ".$baremeFautes; ?></td>
            </tr>
        </table><br>
    </div>
    
    <div class="panel-heading">
        <h2 class="panel-title">Sélectionner un autre questionnaire</h2>
    </div>
    <div class="panel-body">
        <form action="<?php echo $this->bu('eleve', 'resultat', array('cours_name' => $cours_name)); ?>" method="post">
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
            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Vos résultats au questionnaire</button>
        </form>
    </div>
    
</section>