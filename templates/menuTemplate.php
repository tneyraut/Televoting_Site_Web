<nav class="navbar navbar-inverse collapse navbar-collapse navbar-ex1-collapse" role="navigation"> <!-- navbar-fixed-top -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li><a class="navbar-brand" href="<?php echo $this->bu('anonymous') ?>">Accueil</a></li>
            <?php if (isset($user)): ?>
                <?php if ($user->professeur == 0 && $user->admin != 1): ?>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('eleve') ?>">Répondre aux questionnaires</a></li>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('eleve','resultats') ?>">Résultats</a></li>
                <?php endif; ?>
                <?php if ($user->professeur == 1): //&& $user->admin != 1 ?>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('questionnaire','listeCours') ?>">Gestion des questionnaires</a></li>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('statistique') ?>">Résultats et analyses des questionnaires</a></li>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('presence') ?>">Gestions des présences</a></li>
                <?php endif; ?>
                <?php if ($user->admin == 1): ?>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('admin') ?>">Gestion des utilisateurs</a></li>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('admin','ajouterSupprimerCours') ?>">Gestion des cours</a></li>
                <?php endif; ?>
                <?php if ($user->responsable_absence_retard == 1): ?>
                    <li><a class="navbar-brand" href="<?php echo $this->bu('adminPresence') ?>">Administration des présences</a></li>
                <?php endif; ?>
            <?php endif; ?>
        </ul>
    </div>
</nav>