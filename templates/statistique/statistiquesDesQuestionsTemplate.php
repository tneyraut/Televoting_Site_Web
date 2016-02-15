<div class="panel-body">
    <?php if ($statistiquesQuestions == NULL): ?>
        <strong>Ce questionnaire ne comporte aucune question.</strong>
    <?php else: ?>
        <div role="tabpanel">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="statQuestion">
                    <table id="stat" class="table table-striped table-bordered table-condensed">  
                        <thead>
                            <tr> 
                                <th>Question</th> 
                                <th>Nombre de bonnes réponses</th> 
                                <th>Pourcentage de bonnes réponses</th> 
                                <th>Nombre de fautes</th>
                                <th>Nombre de réponses sans réponse</th>
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach ($statistiquesQuestions as $stat): ?>
                                <tr> 
                                    <td> <?php echo $stat[0]; ?> </td> 
                                    <td> <?php echo $stat[1]; ?> </td> 
                                    <td> <?php echo $stat[2]; ?> </td> 
                                    <td> <?php echo $stat[3]; ?> </td> 
                                    <td> <?php echo $stat[4]; ?> </td> 
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>  
</div>