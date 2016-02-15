<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#retards" aria-controls="retards" role="tab" data-toggle="tab">Retards</a></li>
            <li role="presentation"><a href="#absences" aria-controls="absences" role="tab" data-toggle="tab">Absences</a></li>
        </ul>
        <br><br>
        
        <div class="tab-content">
            
            <div role="tabpanel" class="tab-pane fade in active" id="retards">
                <div class="panel-body">
                    <?php if ($retards == NULL): ?>
                        <strong>Aucun retard enregistré.</strong>
                    <?php else: ?>
                        <div role="tabpanel">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="classement">
                                    <table id="tableauRetards" class="table table-striped table-bordered table-condensed">  
                                        <thead>
                                            <tr> 
                                                <th>Prénom.Nom</th> 
                                                <th>Cours</th> 
                                                <th>Date</th>
                                                <th>Justifié</th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <?php foreach ($retards as $element): ?>
                                                <tr> 
                                                    <td> <?php echo $eleve->login; ?> </td> 
                                                    <td> <?php echo $element->cours_name; ?> </td> 
                                                    <td> <?php echo $element->date_value; ?> </td> 
                                                    <td>
                                                        <?php if($element->justifiee == 0): ?>
                                                        <form action="<?php echo $this->bu('adminPresence', 'justificationRetardFromEleveDetail', array('retard_id' => $element->retard_id, 'eleve_id' => $eleve->user_id)); ?>" method="post">
                                                            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg">Archiver</button>
                                                        </form>
                                                        <?php else: echo "OK"; endif; ?>
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
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="absences">
                <div class="panel-body">
                    <?php if ($absences == NULL): ?>
                        <strong>Aucune absence enregistrée.</strong>
                    <?php else: ?>
                        <div role="tabpanel">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="classement">
                                    <table id="tableauAbsences" class="table table-striped table-bordered table-condensed">  
                                        <thead>
                                            <tr> 
                                                <th>Prénom.Nom</th> 
                                                <th>Cours</th> 
                                                <th>Date</th>
                                                <th>Justifié</th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <?php foreach ($absences as $element): ?>
                                                <tr> 
                                                    <td> <?php echo $eleve->login; ?> </td> 
                                                    <td> <?php echo $element->cours_name; ?> </td> 
                                                    <td> <?php echo $element->date_value; ?> </td> 
                                                    <td>
                                                        <?php if($element->justifiee == 0): ?>
                                                        <form action="<?php echo $this->bu('adminPresence', 'justificationAbsenceFromEleveDetail', array('absence_id' => $element->absence_id, 'eleve_id' => $eleve->user_id)); ?>" method="post">
                                                            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg">Archiver</button>
                                                        </form>
                                                        <?php else: echo "OK"; endif; ?>
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
            </div>
            
        </div>
        
    </div>
    
</section>

<script>
    $(document).ready(function() {

        var options = {
            lengthChange: false,
            info: false,
            language: {
                paginate: {
                    previous: 'Précédent',
                    next: 'Suivant'
                },
                search: 'Rechercher'
            }
        };

        $('#tableauRetards').DataTable($.extend({
            searching: true,
            order: [1, 'desc']
        }, options));
        
        $('#tableauAbsences').DataTable($.extend({
            searching: true,
            order: [1, 'desc']
        }, options));

    });
</script>
