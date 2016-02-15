<?php $cours_name = str_replace(' ', '_', $cours_name); ?>

<section class="panel panel-default content">
    
    <div class="panel-heading">
        <h2 class="panel-title">Sélectionner un questionnaire du cours : <?php echo str_replace('_', ' ', $cours_name);; ?></h2>
    </div>
    <div class="panel-body">
        <?php if (count($questionnaires) == 0): ?>
        <strong>
            Aucun questionnaire n'a été créé ou n'est lancée pour ce cours.
        </strong>
        <?php else: ?>
            <form action="<?php echo $this->bu('eleve','choixQuestion',array('cours_name' => $cours_name)); ?>" method="post">
                <table>
                    <tr>
                        <th>Sélectionner un questionnaire :</th>
                        <td>
                            <select name="nomQuestionnaire" class="selectpicker show-tick form-control">
                                <?php foreach($questionnaires as $unQuestionnaire): ?>
                                <option><?php echo $unQuestionnaire->questionnaire_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table><br>
                <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Répondre au questionnaire</button><br>
            </form>
        
            
        
        <?php endif ?>
    </div>
    
    <div class="panel-heading">
        <h2 class="panel-title">Sélection d'un autre cours</h2>
    </div>
    <div class="panel-body">
        
        <form action="<?php echo $this->bu('eleve', 'choixQuestionnaire'); ?>" method="post">
            <table>
                <tr>
                    <th>Sélectionner un cours :</th>
                    <td>
                        <select name="nomCours" class="selectpicker show-tick form-control">
                            <?php foreach ($cours as $unCours): ?>
                                <option><?php echo $unCours->cours_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table><br>
            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button><br>
        </form>
        
        <div role="tabpanel">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="classement">
                    <table id="tableau" class="table table-striped table-bordered table-condensed">  
                        <thead>
                            <tr> 
                                <th>Cours</th> 
                                <th>Nombre de questionnaires à faire</th> 
                                <th>Nombre de questionnaires en cours</th> 
                            </tr> 
                        </thead>
                        <tbody>
                            <?php $compteur = 0; foreach ($cours as $unCours): ?>
                                <tr> 
                                    <td> <?php echo $unCours->cours_name; ?> </td> 
                                    <td> <?php echo $array[$compteur]; ?> </td> 
                                    <td> <?php echo $array[$compteur + 1]; ?> </td> 
                                </tr>
                            <?php $compteur = $compteur + 2; endforeach ?>
                        </tbody>
                    </table>
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

        $('#tableau').DataTable($.extend({
            searching: true,
            order: [0, 'desc']
        }, options));
        
    });
</script>