<section class="panel panel-default content">
    
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#retardsNonJustifies" aria-controls="retardsNonJustifies" role="tab" data-toggle="tab">Retards non justifiés</a></li>
            <li role="presentation"><a href="#absencesNonJustifiees" aria-controls="absencesNonJustifiees" role="tab" data-toggle="tab">Absences non justifiées</a></li>
            <li role="presentation"><a href="#retardsAbsencesEleve" aria-controls="retardsAbsencesEleve" role="tab" data-toggle="tab">Retards et absences par élève</a></li>
            <li role="presentation"><a href="#retardsAbsencesCours" aria-controls="retardsAbsencesCours" role="tab" data-toggle="tab">Retards et absences par cours</a></li>
        </ul>
        <br><br>
        
        <div class="tab-content">
            
            <div role="tabpanel" class="tab-pane fade in active" id="retardsNonJustifies">
                <?php $this->includeTemplate('adminPresence/retardsNonJustifies') ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="absencesNonJustifiees">
                <?php $this->includeTemplate('adminPresence/absencesNonJustifiees') ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="retardsAbsencesEleve">
                <?php $this->includeTemplate('adminPresence/retardsAbsencesEleve') ?>
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="retardsAbsencesCours">
                <?php $this->includeTemplate('adminPresence/retardsAbsencesCours') ?>
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

        $('#tableauAllRetardsNonJustifies').DataTable($.extend({
            searching: true,
            order: [0, 'desc']
        }, options));
        
        $('#tableauAllAbsencesNonJustifiees').DataTable($.extend({
            searching: true,
            order: [0, 'desc']
        }, options));

    });
</script>