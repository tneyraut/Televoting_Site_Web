<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'supprimerUser'); ?>" method="post">
        <table>
            <tr>
                <th>Sélectionner un utilisateur :</th>
                <td>
                    <select name="nomUser" class="selectpicker show-tick form-control">
                        <?php foreach ($users as $unUser): if ($user->login != $unUser->login): ?>
                                <option><?php echo $unUser->login; ?></option>
                        <?php endif; endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Ou rentrer un login :</th>
                <td><input type="text" placeholder="Rentrer le login d'un utilisateur" class="input-control form-control" name="user_name"></td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Supprimer l'utilisateur</button>
    </form>
    <br>
    
    <form enctype="multipart/form-data" action="<?php echo $this->bu('admin', 'supprimerUserExcel'); ?>" method="post">
        <table>
            <tr>
                <th>Importer un fichier excel :</th>
                <td><input type="file" class="btn btn-default" name="excel" id="excel" /></td>
            </tr>
        </table><br>
        <button id="btn" type="submit" class="btn btn-primary btn-lg center">Supprimer users</button>
    </form>
    
</div>