<section class="panel panel-default content">
    <div class="panel-heading">
        <h2 class="panel-title">Accueil</h2>
    </div>
    <img class="img-logo" src="<?php echo $this->bu() ?>images/logoMinesDouai.jpg" />
    <div class="panel-body">
        <strong>Bienvenu sur le site Application Televoting !</strong><br><br>
        <?php if (isset($user)): ?>
        <?php if ($user->professeur == 1 || $user->admin == 1): ?>
        Ce site vous permet via les différents menus de :<br>
         - Créer des questionnaires personnalisables de types QCM<br>
         - Consulter et modifier vos questionnaires<br>
         - Générer les résultats et analyses de vos questionnaires<br><br> 
         
        <video controls="controls" width="800" height="600" name="Video Name" src="video/video.mp4"></video>
        <br><br>
         
        <?php else: ?>
        Ce site vous permet via le menu de répondre aux différents questionnaires proposés par vos enseignants.<br><br>
        <strong>Il vous reste <?php echo $nombreQuestionnairesAFaire; ?> questionnaires à faire dont <?php echo $nombreQuestionnaireEnCours; ?> questionnaires en cours.</strong><br><br>
        <?php endif; ?>
        <?php else: ?>
        Afin d'accéder aux fonctionnalités de ce site veuillez vous identifier.<br><br>
        <?php endif; ?>
        Pour les demandes suivantes : <br>
         - Création / Suppression d'un compte<br>
         - Création / Suppression d'un cours,<br>
        veuillez contacter l'administrateur à l'adresse mail suivante 
        thomas.neyraut@minesdedouai.fr
    </div>
</section>