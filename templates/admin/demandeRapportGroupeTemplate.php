<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'genererRapportGroupe'); ?>" method="post">
        <table>
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
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Obtenir un rapport de groupe</button>
    </form>
</div>