<div class="panel-body">
    
    <?php if (count($eleves) == 0): ?>
        <strong>
            Aucun élève est enregistré.
        </strong>
    <?php else: ?>
        <form action="<?php echo $this->bu('adminPresence','listeRetardsAbsencesEleve'); ?>" method="post">
            <table>
                <tr>
                    <th>Sélectionner un élève :</th>
                    <td>
                        <select name="eleve_name" class="selectpicker show-tick form-control">
                            <?php foreach($eleves as $eleve): ?>
                            <option><?php echo $eleve->login; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table><br>
            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>
        </form>
    <?php endif ?>
    
</div>