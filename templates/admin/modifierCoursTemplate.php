<section class="panel panel-default content">
    <div class="panel-heading">
        <h2 class="panel-title">Modification du cours : <?php echo $cours->cours_name; ?></h2>
    </div>
    <div class="panel-body">
        <?php if (isset($erreur)): ?>
            <div class="alert alert-danger" role="alert"><?php echo $erreur ?></div>
        <?php endif ?>
        <form action="<?php echo $this->bu('admin', 'modifierCours', array('cours_name_actuel' => str_replace(' ', '_', $cours->cours_name))); ?>" method="post">
            <table>
                <tr>
                    <th>Nom du cours :</th>
                    <td><?php echo $cours->cours_name; ?></td>
                </tr>
                <tr>
                    <th>Changer de nom :</th>
                    <td><input type="text" placeholder="nom du cours" class="input-control form-control" name="cours_name"></td>
                </tr>
                <tr>
                    <th>Année d'enseignement du cours (première, deuxième année...) :</th>
                    <td><?php echo $cours->annee; ?></td>
                </tr>
                <tr>
                    <th>Changer d'Année d'enseignement :</th>
                    <td><input type="text" placeholder="un entier entre 1 et 5" class="input-control form-control" name="annee"></td>
                </tr>
                <tr>
                    <th>Groupe actuel :</th>
                    <td><?php echo $groupe->groupe_name; ?></td>
                </tr>
                <tr>
                    <th>Changer de groupe :</th>
                    <td>
                        <select name="groupe_name" class="selectpicker show-tick form-control">
                            <option><?php echo $groupe->groupe_name; ?></option>
                            <?php foreach ($groupes as $unGroupe): if ($unGroupe->groupe_name != $groupe->groupe_name): ?>
                                <option><?php echo $unGroupe->groupe_name; ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Professeur en charge de ce cours :</th>
                    <td><?php echo $professeur->login; ?></td>
                </tr>
                <tr>
                    <th>Changer de professeur :</th>
                    <td>
                        <select name="professeur_name" class="selectpicker show-tick form-control">
                            <option><?php echo $professeur->login; ?></option>
                            <?php foreach ($professeurs as $unProfesseur): if ($unProfesseur->login != $professeur->login): ?>
                                <option><?php echo $unProfesseur->login ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table><br>
            <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Modifier le cours</button>
        </form>
    </div>
</section>