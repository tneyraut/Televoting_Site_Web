<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'supprimerCours'); ?>" method="post">
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
            <tr>
                <th>Ou rentrer un cours :</th>
                <td><input type="text" placeholder="Rentrer un cours" class="input-control form-control" name="cours_name"></td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Supprimer le cours</button>
    </form>
    <br>
    
    <form enctype="multipart/form-data" action="<?php echo $this->bu('admin', 'supprimerCoursExcel'); ?>" method="post">
        <table>
            <tr>
                <th>Importer un fichier excel :</th>
                <td><input type="file" class="btn btn-default" name="excel" id="excel" /></td>
            </tr>
        </table><br>
        <button id="btn" type="submit" class="btn btn-primary btn-lg center">Supprimer cours</button>
    </form>
    
</div>