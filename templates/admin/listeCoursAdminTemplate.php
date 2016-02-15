<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#ajouterCours" aria-controls="ajouterCours" role="tab" data-toggle="tab">Ajouter un cours</a></li>
            <li role="presentation"><a href="#supprimerCours" aria-controls="supprimerCours" role="tab" data-toggle="tab">Supprimer un cours</a></li>
            <li role="presentation"><a href="#modifierCours" aria-controls="modifierCours" role="tab" data-toggle="tab">Modifier un cours</a></li>
        </ul>
        <br><br>
        <div class="tab-content">
            <?php if (isset($erreur)): ?>
                <div class="alert alert-danger" role="alert"><?php echo $erreur ?></div>
            <?php endif ?>
            <div role="tabpanel" class="tab-pane fade in active" id="ajouterCours">
                <?php $this->includeTemplate('admin/ajouterCours') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="supprimerCours">
                <?php $this->includeTemplate('admin/supprimerCours') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="modifierCours">
                <?php $this->includeTemplate('admin/selectionnerCours') ?>
            </div>
        </div>
    </div>
    
</section>