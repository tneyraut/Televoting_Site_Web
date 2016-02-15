<div class="panel-body">
    <?php if ($allAbsencesNonJustifiees == NULL): ?>
        <strong>Aucune absence non justifiée enregistrée.</strong>
    <?php else: ?>
        <div role="tabpanel">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="classement">
                    <table id="tableauAllAbsencesNonJustifiees" class="table table-striped table-bordered table-condensed">  
                        <thead>
                            <tr> 
                                <th>Prénom.Nom</th> 
                                <th>Cours</th> 
                                <th>Date</th>
                                <th>Justifié</th>
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach ($allAbsencesNonJustifiees as $element): ?>
                                <tr> 
                                    <td> <?php echo $element->login; ?> </td> 
                                    <td> <?php echo $element->cours_name; ?> </td> 
                                    <td> <?php echo $element->date_value; ?> </td> 
                                    <td>
                                        <form action="<?php echo $this->bu('adminPresence', 'justificationAbsence', array('absence_id' => $element->absence_id)); ?>" method="post">
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
