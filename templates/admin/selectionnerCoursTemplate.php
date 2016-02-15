<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'selectionnerCours'); ?>" method="post">
        <table>
            <tr>
                <th>Sélectionner un cours :</th>
                <td>
                    <select name="cours_name" class="selectpicker show-tick form-control">
                        <?php foreach ($cours as $unCours): ?>
                            <option><?php echo $unCours->cours_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Valider</button>
    </form>
</div>