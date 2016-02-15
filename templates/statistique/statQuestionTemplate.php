<?php
$nomCours = str_replace(' ', '_', $nomCours);
$questionnaire_name = str_replace(' ', '_', $questionnaire_name);
?>

<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#statistiquesQuestion" aria-controls="statistiquesQuestion" role="tab" data-toggle="tab">Statistiques de la question : <?php echo $question_name; ?></a></li>
            <li role="presentation"><a href="#statistiquesReponse" aria-controls="statistiquesReponse" role="tab" data-toggle="tab">Statistiques par réponse</a></li>
            <li role="presentation"><a href="#selectQuestion" aria-controls="selectQuestion" role="tab" data-toggle="tab">Sélectionner une autre question</a></li>
        </ul>
        <br><br>
        <div class="tab-content">
            
            <div role="tabpanel" class="tab-pane fade in active" id="statistiquesQuestion">
                <?php $this->includeTemplate('statistique/statistiquesQuestion') ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="statistiquesReponse">
                <?php $this->includeTemplate('statistique/statistiquesReponses') ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="selectQuestion">
                <div class="panel-body">
                    <form action="<?php echo $this->bu('statistique', 'statQuestion', array('nomCours' => $nomCours, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                        <table>
                            <tr>
                                <th>Sélectionner une question :</th>
                                <td>
                                    <select name="question_name" class="selectpicker show-tick form-control">
                                        <?php foreach ($questions as $question): ?>
                                            <option><?php echo $question->question; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </table><br>
                        <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>
                    </form>
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
            order: [3, 'desc']
        }, options));
        
    });
</script>