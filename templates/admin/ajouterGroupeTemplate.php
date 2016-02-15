<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'ajouterGroupe'); ?>" method="post">
        <table>
            <tr>
                <th>Nom du groupe :</th>
                <td><input type="text" placeholder="nom du groupe" class="input-control form-control" name="groupe_name"></td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Ajouter le groupe</button>
    </form>
    <br>
    
    <form enctype="multipart/form-data" action="<?php echo $this->bu('admin', 'ajouterGroupeExcel'); ?>" method="post">
        <table>
            <tr>
                <th>Importer un fichier excel :</th>
                <td><input type="file" class="btn btn-default" name="excel" id="excel" /></td>
            </tr>
        </table><br>
        <button id="btn" type="submit" class="btn btn-primary btn-lg center">Ajouter groupes</button>
    </form>
    
</div>