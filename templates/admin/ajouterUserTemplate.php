<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'ajouterUser'); ?>" method="post">
        <table>
            <tr>
                <th>Login de l'utilisateur :</th>
                <td><input type="text" placeholder="login de l'utilisateur" class="input-control form-control" name="login"></td>
            </tr>
            <tr>
                <th>Mot de passe :</th>
                <td><input type="password" placeholder="mot de passe de l'utilisateur" class="input-control form-control" name="password"></td>
            </tr>
            <tr>
                <th>Mot de passe confirmation:</th>
                <td><input type="password" placeholder="confirmation" class="input-control form-control" name="confirmation"></td>
            </tr>
            <tr>
                <th>L'utilisateur est-il un professeur ou un eleve :</th>
                <td>
                    <select name="professeur" class="selectpicker show-tick form-control">
                        <option>eleve</option>
                        <option>professeur</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Droits d'administrateur :</th>
                <td>
                    <select name="admin" class="selectpicker show-tick form-control">
                        <option>Non</option>
                        <option>Oui</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Si l'utilisateur est un eleve, rentrez son année :</th>
                <td><input type="text" placeholder="entier entre 1 et 5" class="input-control form-control" name="annee"></td>
            </tr>
            <tr>
                <th>Si l'utilisateur est un eleve, rentrez sa promotion :</th>
                <td><input type="text" placeholder="entier (exemple : 2016)" class="input-control form-control" name="promotion"></td>
            </tr>
            <tr>
                <th>Si l'utilisateur est un eleve, choisissez un groupe :</th>
                <td>
                    <select name="groupe_name" class="selectpicker show-tick form-control">
                        <?php foreach ($groupes as $groupe): ?>
                        <option><?php echo $groupe->groupe_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Ajouter l'utilisateur</button>
    </form>
    <br>
    
    <form enctype="multipart/form-data" action="<?php echo $this->bu('admin', 'ajouterUserExcel'); ?>" method="post">
        <table>
            <tr>
                <th>Importer un fichier excel :</th>
                <td><input type="file" class="btn btn-default" name="excel" id="excel" /></td>
            </tr>
        </table><br>
        <button id="btn" type="submit" class="btn btn-primary btn-lg center">Ajouter users</button>
    </form>
    
</div>