<div class="panel-body">
    <form action="<?php echo $this->bu('admin', 'modificationPromotion'); ?>" method="post">
        <table>
            <tr>
                <th>Rentrer une promotion :</th>
                <td><input type="text" placeholder="entier (exemple: 2016)" class="input-control form-control" name="promotion"></td>
            </tr>
            <tr>
                <th>Modification de l'année :</th>
                <td>
                    <select name="annee" class="selectpicker show-tick form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Supprimer la promotion :</th>
                <td>
                    <select name="supprimer" class="selectpicker show-tick form-control">
                        <option>Non</option>
                        <option>Oui</option>
                    </select>
                </td>
            </tr>
        </table><br>
        <button id="btn-supprimer" type="submit" class="btn btn-primary btn-lg center">Valider les modifications</button>
    </form>
</div>