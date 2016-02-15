<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'ajouterCours'); ?>" method="post">
        <table>
            <tr>
                <th>Nom du cours :</th>
                <td><input type="text" placeholder="nom du cours" class="input-control form-control" name="cours_name"></td>
            </tr>
            <tr>
                <th>Année d'enseignement du cours (première, deuxième année...) :</th>
                <td><input type="text" placeholder="un entier entre 1 et 5" class="input-control form-control" name="annee"></td>
            </tr>
            <tr>
                <th>Groupe :</th>
                <td>
                    <select name="groupe_name" class="selectpicker show-tick form-control">
                        <?php foreach ($groupes as $groupe): ?>
                            <option><?php echo $groupe->groupe_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Sélectionner le nom du professeur en charge de ce cours :</th>
                <td>
                    <select name="professeur_name" class="selectpicker show-tick form-control">
                        <?php foreach ($professeurs as $professeur): ?>
                            <option><?php echo $professeur->login ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Ajouter le cours</button>
    </form>
    <br>
    
    <form enctype="multipart/form-data" action="<?php echo $this->bu('admin', 'ajouterCoursExcel'); ?>" method="post">
        <table>
            <tr>
                <th>Importer un fichier excel :</th>
                <td><input type="file" class="btn btn-default" name="excel" id="excel" /></td>
            </tr>
        </table><br>
        <button id="btn" type="submit" class="btn btn-primary btn-lg center">Ajouter cours</button>
    </form>
    
</div>