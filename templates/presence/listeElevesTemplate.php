<section class="panel panel-default content">
    <div class="panel-heading">
        <h2 class="panel-title"><?php echo $cours->cours_name . " : Liste des élèves"; ?></h2>
    </div>
    <div class="panel-body">
        
        <form action="<?php echo $this->bu('presence', 'validationPresences', array('cours_name' => str_replace(' ', '_', $cours->cours_name))); ?>" method="post">
                
            <table>
            <?php foreach ($users as $user): ?>
                <tr>
                    <th><?php echo $user->login; ?></th>
                    <td>
                        <select name="<?php echo $user->user_id; ?>" class="selectpicker show-tick form-control">
                            <option>Présent</option>
                            <option>En retard</option>
                            <option>Absent</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach;
            if (count($users) == 0): ?>
                <tr>
                    <th>Aucun élève est enregistré pour ce cours</th>
                </tr>
            </table>
            <?php else : ?>

                <tr>
                    <th>Jour</th>
                    <td>
                        <select name="day" class="selectpicker show-tick form-control">
                            <?php for ($i=1;$i<=9;$i++): ?>
                            <option><?php echo "0" . $i; ?></option>
                            <?php endfor; ?>
                            <?php for ($i=10;$i<=31;$i++): ?>
                            <option><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>Mois</th>
                    <td>
                        <select name="month" class="selectpicker show-tick form-control">
                            <?php for ($i=1;$i<=9;$i++): ?>
                            <option><?php echo "0" . $i; ?></option>
                            <?php endfor; ?>
                            <?php for ($i=10;$i<=12;$i++): ?>
                            <option><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>Année</th>
                    <td>
                        <select name="year" class="selectpicker show-tick form-control">
                            <?php for ($i=2015;$i<=2016;$i++): ?>
                            <option><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                </tr>

            </table>
            
            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>

            <?php endif; ?>

        </form>

    </div>
</section>