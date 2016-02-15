<div id="rightDock">
<?php if($user === NULL): ?>
    <aside id="panel-connexion" class="panel panel-default panel-connexion">
        <div class="panel-heading">
            <h2 class="panel-title">Connexion</h2>
        </div>
        <div class="panel-body">
            <?php $this->includeTemplate('loginForm') ?>
        </div>
    </aside>
<?php else: ?>
    <aside id="panel-connexion" class="panel panel-default panel-connexion">
        <div class="panel-heading">
            <h2 class="panel-title">Connecté</h2>
        </div>
        <div class="panel-body">
            Bonjour <?php echo $user->login ?>.<br/>
            <a href="<?php echo $this->bu('user', 'deconnecter') ?>">Se déconnecter</a>
        </div>
    </aside>
<?php endif ?>
    
</div>