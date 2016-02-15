<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'transfererGroupe'); ?>" method="post">
        <table>
            <tr>
                <th>Sélectionner un groupe à transférer :</th>
                <td>
                    <select name="groupe_name_origine" class="selectpicker show-tick form-control">
                        <?php foreach ($groupes as $groupe): ?>
                            <option><?php echo $groupe->groupe_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Sélectionner un groupe destination :</th>
                <td>
                    <select name="groupe_name_destination" class="selectpicker show-tick form-control">
                        <?php foreach ($groupes as $groupe): ?>
                            <option><?php echo $groupe->groupe_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Transférer</button>
    </form>
</div>