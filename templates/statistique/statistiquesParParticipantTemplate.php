<div class="panel-body">
    <?php if ($participants == NULL): ?>
        <strong>Personne n'a répondu à votre questionnaire.</strong>
    <?php else: ?>
        <div role="tabpanel">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="classement">
                    <table id="tableau" class="table table-striped table-bordered table-condensed">  
                        <thead>
                            <tr> 
                                <th>Prénom.Nom</th> 
                                <th>Promotion</th> 
                                <th>Année</th> 
                                <th>Note</th>
                                <th>Nombre de bonnes réponses</th>
                                <th>Nombre de fautes</th>
                            </tr> 
                        </thead>
                        <tbody>
                            <?php foreach ($participants as $participant): ?>
                                <tr> 
                                    <td> <?php echo $participant->login; ?> </td> 
                                    <td> <?php echo $participant->promotion; ?> </td> 
                                    <td> <?php echo $participant->annee; ?> </td> 
                                    <td> <?php echo $participant->note; ?> </td> 
                                    <td> <?php echo $participant->nombre_de_bonnes_reponses; ?> </td> 
                                    <td> <?php echo $participant->nombre_de_fautes; ?> </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>  
</div>