<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#ajouterUser" aria-controls="ajouterUser" role="tab" data-toggle="tab">Ajouter un utilisateur</a></li>
            <li role="presentation"><a href="#supprimerUser" aria-controls="supprimerUser" role="tab" data-toggle="tab">Supprimer un utilisateur</a></li>
            <li role="presentation"><a href="#modifierPromotion" aria-controls="modifierPromotion" role="tab" data-toggle="tab">Modifier une promotion</a></li>
            <li role="presentation"><a href="#ajouterGroupe" aria-controls="ajouterGroupe" role="tab" data-toggle="tab">Ajouter un groupe</a></li>
            <li role="presentation"><a href="#supprimerGroupe" aria-controls="supprimerGroupe" role="tab" data-toggle="tab">Supprimer un groupe</a></li>
            <li role="presentation"><a href="#modifierGroupe" aria-controls="modifierGroupe" role="tab" data-toggle="tab">Modifier un groupe</a></li>
            <li role="presentation"><a href="#viderGroupe" aria-controls="viderGroupe" role="tab" data-toggle="tab">Vider un groupe</a></li>
            <li role="presentation"><a href="#transfererGroupe" aria-controls="transfererGroupe" role="tab" data-toggle="tab">Transférer un groupe</a></li>
            <li role="presentation"><a href="#rapportGroupe" aria-controls="rapportGroupe" role="tab" data-toggle="tab">Rapport groupe</a></li>
        </ul>
        <br><br>
        <div class="tab-content">
            <?php if (isset($erreur)): ?>
                <div class="alert alert-danger" role="alert"><?php echo $erreur ?></div>
            <?php endif ?>
            <div role="tabpanel" class="tab-pane fade in active" id="ajouterUser">
                <?php $this->includeTemplate('admin/ajouterUser') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="supprimerUser">
                <?php $this->includeTemplate('admin/supprimerUser') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="modifierPromotion">
                <?php $this->includeTemplate('admin/modifierPromotion') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="ajouterGroupe">
                <?php $this->includeTemplate('admin/ajouterGroupe') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="supprimerGroupe">
                <?php $this->includeTemplate('admin/supprimerGroupe') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="modifierGroupe">
                <?php $this->includeTemplate('admin/modifierGroupe') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="viderGroupe">
                <?php $this->includeTemplate('admin/viderGroupe') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="transfererGroupe">
                <?php $this->includeTemplate('admin/transfererGroupe') ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="rapportGroupe">
                <?php $this->includeTemplate('admin/demandeRapportGroupe') ?>
            </div>
        </div>
    </div>
        
</section>