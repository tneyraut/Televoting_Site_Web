<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'supprimerGroupe'); ?>" method="post">
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
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Supprimer le groupe</button>
    </form>
    <br>
    
    <form enctype="multipart/form-data" action="<?php echo $this->bu('admin', 'supprimerGroupeExcel'); ?>" method="post">
        <table>
            <tr>
                <th>Importer un fichier excel :</th>
                <td><input type="file" class="btn btn-default" name="excel" id="excel" /></td>
            </tr>
        </table><br>
        <button id="btn" type="submit" class="btn btn-primary btn-lg center">Supprimer groupes</button>
    </form>
    
</div>