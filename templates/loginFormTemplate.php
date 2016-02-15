<div>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
    <?php endif ?>
    <form action="<?php echo $this->bu('anonymous', 'login') ?>" method="post">
        <input type="text" placeholder="Identifiant" class="input-control form-control" name="login">
        <input type="password" placeholder="Password" class="input-control form-control" name="password">
        <button id="btn-connexion" type="submit" class="btn btn-success">Se connecter</button>
    </form>
</div>