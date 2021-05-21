 <div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title font-weight-bold">Liste de mes transferts de crédit</h2>
            </div>
            <div class="card-body">
                <table class="table table-success table-striped table-borderless" id="credits-table">
                    <thead class="table-light">
                    <tr>
                        <th>Actions</th>
                        <th>Transactions</th>
                        <th>Notes</th>
                        <th>Date d'envoie</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script defer>
        $(function() {

            $('#credits-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                method:'post',
                dom: 'Bfrliptip',
                ajax: '{{ route("user.userSentTransactions") }}',
                columns: [
                    { data: null, name: 'action',
                        render: data => {
                            let type_text = data.sent_by.id==={{$user->id}}?"<strong>Envoie</strong>":"<strong>Réception</strong>";
                            return `<span>${type_text} <br><i class="${data.credit.icons}"></i> ${data.credit?.name}</span>`;
                        }
                    },
                    { data: null, name: 'sent_to',
                        render: data => {
                            if(data.sent_by.id == "{{$user->id}}")
                                return `<span class="sent_by">Vous avez</span> envoyé ${data.sent_value} ${data.credit.name} à <span class="sent_to"> ${data.sent_to?data.sent_to.name:"Utilisateur supprimé"}</span>`;
                            else
                                return `<span class="sent_by">${data.sent_by?data.sent_by.name:"Utilisateur supprimé"}</span> vous a envoyé ${data.sent_value} ${data.credit.name}`;
                            }
                    },
                    { data: null, name: 'notes',
                        render: data => {
                                const notesHTML = data.notes?data.notes:'';
                                const notes = $("<div>").html(data.notes).text();
                                return `<div class='log-notes'>${notes}</div>`;
                        }
                    },
                    { data: 'updated_at', name: 'updated_at' }
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 3, 'desc' ]],
                pageLength: 100,
                responsive: true,
                "oLanguage":{
                      "sProcessing":     "<i class='fa fa-2x fa-spinner fa-pulse'>",
                      "sSearch":         "Rechercher&nbsp;:",
                      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                      "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                      "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                      "sInfoPostFix":    "",
                      "sLoadingRecords": "Chargement en cours...",
                      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
                      "sEmptyTable":     "Vous n'avez pas encore de transaction.",
                      "oPaginate": {
                        "sFirst":      "<| ",
                        "sPrevious":   "Prec",
                        "sNext":       " Suiv",
                        "sLast":       " |>"
                      },
                      "oAria": {
                        "sSortAscending":  ": activez pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activez pour trier la colonne par ordre décroissant"
                      }
                    }
            });
        });
    </script>