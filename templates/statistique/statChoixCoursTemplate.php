<section class="panel panel-default content">
    <div class="panel-heading">
        <h2 class="panel-title">Sélection d'un cours enseigné</h2>
    </div>
    <div class="panel-body">
        <?php if (count($cours) == 0): ?>
        <strong>
            Vous n'avez aucun cours enregistré.
            Afin d'ajouter un cours veuillez contacter l'administrateur à l'adresse mail suivante : thomas.neyraut@minesdedouai.fr
        </strong>
        <?php else: ?>
            <form action="<?php echo $this->bu('statistique','statChoixQuestionnaire'); ?>" method="post">
                <table>
                    <tr>
                        <th>Sélectionner un cours :</th>
                        <td>
                            <select name="nomCours" class="selectpicker show-tick form-control">
                                <?php foreach($cours as $unCours): ?>
                                <option><?php echo $unCours->cours_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table><br>
                <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>
            </form>
        <?php endif ?>
    </div>
</section>