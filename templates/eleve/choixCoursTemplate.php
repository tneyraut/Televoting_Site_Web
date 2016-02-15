<section class="panel panel-default content">
    <div class="panel-heading">
        <h2 class="panel-title">Sélection d'un cours enseigné</h2>
    </div>
    <div class="panel-body">
        <?php if (count($cours) == 0): ?>
        <strong>
            Vous n'avez aucun cours enregistré.
        </strong>
        <?php else: ?>
            
            <form action="<?php echo $this->bu('eleve','choixQuestionnaire'); ?>" method="post">
                <table>
                    <tr>
                        <th>Sélectionner un cours :</th>
                        <td>
                            <select name="nomCours" class="selectpicker show-tick form-control">
                                <?php foreach($cours as $unCours): ?>
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
            
        <?php endif ?>
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