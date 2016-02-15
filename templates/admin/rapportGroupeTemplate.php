<section class="panel panel-default content">
    <div class="panel-heading">
        <h2 class="panel-title">Rapport du groupe : <?php echo $groupe_name; ?></h2>
    </div>
    <div class="panel-body">
        <table>
            <?php foreach ($users as $user): ?>
            <tr>
                <th><?php echo $user->login; ?></th>
            </tr>
            <?php endforeach; if (count($users) == 0): ?>
            <tr>
                <th>Ce groupe n'est composé d'aucun élève</th>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</section>