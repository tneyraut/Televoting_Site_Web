<div class="panel-body">
    <?php if ($allRetardsNonJustifies == NULL): ?>
        <strong>Aucun retard non justifié enregistré.</strong>
    <?php else: ?>
        <div role="tabpanel">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="classement">
                    <table id="tableauAllRetardsNonJustifies" class="table table-striped table-bordered table-condensed">  
                        <thead>
                            <tr> 
                                <th>Prénom.Nom</th> 
                                <th>Cours</th> 
                                <th>Date</th>
                                <th>Justifié</th>
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach ($allRetardsNonJustifies as $element): ?>
                                <tr> 
                                    <td> <?php echo $element->login; ?> </td> 
                                    <td> <?php echo $element->cours_name; ?> </td> 
                                    <td> <?php echo $element->date_value; ?> </td> 
                                    <td>
                                        <form action="<?php echo $this->bu('adminPresence', 'justificationRetard', array('retard_id' => $element->retard_id)); ?>" method="post">
                                            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg">Archiver</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>  
</div>