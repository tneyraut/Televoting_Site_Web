<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'AjouterSupprimerUserUnGroupe'); ?>" method="post">
        <table>
            <tr>
                <th>Ajouter / Supprimer un élève d'un groupe</th>
            </tr>
            <tr>
                <th>Sélectionner un utilisateur :</th>
                <td>
                    <select name="login" class="selectpicker show-tick form-control">
                        <?php foreach ($users as $user): ?>
                            <option><?php echo $user->login; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Sélectionner un groupe :</th>
                <td>
                    <select name="groupe_name" class="selectpicker show-tick form-control">
                        <?php foreach ($groupes as $groupe): ?>
                            <option><?php echo $groupe->groupe_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Mode :</th>
                <td>
                    <select name="mode" class="selectpicker show-tick form-control">
                        <option>Ajouter</option>
                        <option>Supprimer</option>
                    </select>
                </td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Valider</button>
    </form>
</div>