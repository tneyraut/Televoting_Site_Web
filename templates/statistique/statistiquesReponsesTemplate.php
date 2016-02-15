<div class="panel-body">
    <?php if ($nombreTypesReponses == NULL): ?>
        <strong>Personne n'a répondu à votre questionnaire / Cette question ne dispose d'aucune réponse.</strong>
    <?php else: ?>
        <div role="tabpanel">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="classement">
                    <table id="tableau" class="table table-striped table-bordered table-condensed">  
                        <thead>
                            <tr> 
                                <th>Réponse</th> 
                                <th>Nombre</th> 
                                <th>Pourcentage</th> 
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach ($nombreTypesReponses as $reponse): ?>
                                <tr> 
                                    <td> <?php echo $reponse->reponse; ?> </td> 
                                    <td> <?php echo $reponse->resultat; ?> </td> 
                                    <td> <?php echo $reponse->resultat / $nombreParticipants * 100 . " %"; ?> </td> 
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>  
</div>