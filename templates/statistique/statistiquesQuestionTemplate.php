<div class="panel-body">
    <table>
        <tr>
            <th>Nombre de bonnes réponses :</th>
            <td><?php echo $nombreBonnesReponsesParticipant; ?></td>
        </tr>
        <tr>
            <th>Pourcentage de bonnes réponses :</th>
            <td><?php echo $nombreBonnesReponsesParticipant / $nombreParticipants * 100 . " %"; ?></td>
        </tr>
        <tr>
            <th>Nombre de fautes :</th>
            <td><?php echo $nombreFautesParticipant; ?></td>
        </tr>
        <tr>
            <th>Nombre de réponses sans réponse :</th>
            <td><?php echo $nombreReponsesSansReponse; ?></td>
        </tr>
    </table><br>
</div>