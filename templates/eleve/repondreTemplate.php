<?php
$cours_name = str_replace(' ', '_', $cours_name);
$questionnaire_name = str_replace(' ', '_', $questionnaire_name);
?>

<?php if($question->temps_imparti > 0): ?>
<script>
    var temps = <?php echo $question->temps_imparti; ?>;
    document.write(temps);
    $(document).ready(function() {
        var z = setInterval(function() {temps--;}, 1000);
        var y = setInterval(function () {document.getElementById('btn-valider').click(); clearTimeout(y); clearTimeout(z);}, <?php echo $question->temps_imparti * 1000; ?>);
    });
</script>
<?php endif; ?>

<section class="panel panel-default content">
    <div class="panel-heading">
        <h2 class="panel-title">Répondez à la question</h2>
    </div>
    <div class="panel-body">
        <form action="<?php echo $this->bu('eleve', 'reponseValidee', array('cours_name' => $cours_name, 'questionnaire_name' => $questionnaire_name, 'question_id' => $question->question_id)); ?>" method="post">
            <table>
                <?php if($question->temps_imparti > 0): ?>
                    <tr>
                        <th>Attention temps imparti : </th>
                        <td><?php echo $question->temps_imparti; ?> secondes</td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><?php echo $question->question; ?></th>
                    <th><?php if ($question->image != NULL): ?><img class="imageUpload" src="<?php echo $this->bu().$question->image; ?>"/><?php endif; ?></th>
                </tr>
            </table><br>
            <table>
                <?php foreach ($reponses as $reponse): ?>
                <tr>
                    <th>
                        <label>
                            <input type="checkbox" name="reponse[]" value="<?php echo $reponse->reponse; ?>"><?php echo $reponse->reponse; ?>
                        </label>
                    </th>
                    <td><?php if ($reponse->image != NULL): ?><img class="imageUpload" src="<?php echo $this->bu().$reponse->image; ?>"/><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
            </table><br>
            <button id="btn-valider" type="submit" class="btn btn-primary btn-lg center">Valider</button>
        </form>
    </div>
</section>