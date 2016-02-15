<?php
$nomCours = $cours->cours_name;
$nomCours = str_replace(' ', '_', $nomCours);
$questionnaire_name = $questionnaire->questionnaire_name;
$questionnaire_name = str_replace(' ', '_', $questionnaire_name);
?>

<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#statsGenerales" aria-controls="statsGenerales" role="tab" data-toggle="tab">Statistiques générales</a></li>
            <li role="presentation"><a href="#statsParticipant" aria-controls="statsParticipant" role="tab" data-toggle="tab">Statistiques par participant</a></li>
            <li role="presentation"><a href="#statsDesQuestions" aria-controls="statsDesQuestions" role="tab" data-toggle="tab">Statistiques des questions</a></li>
            <li role="presentation"><a href="#statsParQuestion" aria-controls="statsParQuestion" role="tab" data-toggle="tab">Statistiques par question</a></li>
            <li role="presentation"><a href="#selectQuestionnaire" aria-controls="selectQuestionnaire" role="tab" data-toggle="tab">Sélectionner un autre questionnaire</a></li>
        </ul>
        <br><br>
        <div class="tab-content">
            
            <div role="tabpanel" class="tab-pane fade in active" id="statsGenerales">
                <?php $this->includeTemplate('statistique/statistiquesGenerales') ?>
                <form action="<?php echo $this->bu('statistique', 'generationPDF', array('cours_name' => $nomCours, 'questionnaire_name' => $questionnaire_name)); ?>" method="post">
                    <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Générer un pdf résultat</button>
                </form><br>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="statsParticipant">
                <?php $this->includeTemplate('statistique/statistiquesParParticipant') ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="statsDesQuestions">
                <?php $this->includeTemplate('statistique/statistiquesDesQuestions') ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="statsParQuestion">
                <div class="panel-body">
                    <?php if ($questions == NULL): ?>
                        <strong>Votre questionnaire n'est composé d'aucune question.</strong>
                    <?php else: ?>
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
                    <?php endif; ?>
                </div>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="selectQuestionnaire">
                <?php $this->includeTemplate('statistique/') ?>
                <div class="panel-body">
                    <form action="<?php echo $this->bu('statistique', 'statistiqueQuestionnaire', array('nomCours' => $nomCours)); ?>" method="post">
                        <table>
                            <tr>
                                <th>Sélectionner un questionnaire :</th>
                                <td>
                                    <select name="nomQuestionnaire" class="selectpicker show-tick form-control">
                                        <?php foreach ($questionnaires as $unQuestionnaire): ?>
                                            <option><?php echo $unQuestionnaire->questionnaire_name; ?></option>
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
        
        $('#stat').DataTable($.extend({
            searching: true,
            order: [3, 'desc']
        }, options));

    });
</script>