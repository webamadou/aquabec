@extends('layouts.back.admin')

@section('title','Utilisateurs ')

@section('content')

    <div class="row">
        <div><a href="{{route('admin.users.create')}}" class="btn btn-primary mb-4 mb-4"><i class="fa fa-user-plus"></i> Inscrire un équipier </a></div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des utilisateurs</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="event-users-table">
                        <thead>
                        <tr>
                            <th> - </th>
                            <th>Nom & Prénom</th>
                            <th>Adresse Email</th>
                            <th>Fonctions</th>
                            <th>Dernière modification</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script>
        $(function() {
            $('#event-users-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                ajax: '{{ url('admin/get-users-data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: null, name: 'name',
                        render: data => { return `<strong><i class="fa fa-user"></i> <a href="/admin/users/${data.id}" class="text-link">${data.name?data.name:''} ${data.prenom?data.prenom:''} </a></strong>`; }
                    },
                    { data: 'email', name: 'email' },
                    { data: null, name: 'fonctions',
                        render : data => {
                            let user_roles = '';
                            if(data.roles != null){
                                const roles = data.roles;
                                for(let role in roles){
                                    if(roles.hasOwnProperty(role)){
                                        user_roles += `<span class="badge badge-primary">${roles[role].name}</span> <br>`
                                    }
                                }
                            }
                            return user_roles;
                            return data.roles ? data.roles.name : 'non defini';
                        }
                    },
                    { data: 'updated_at', name: 'updated_at', width: '150' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '80' }
                ],
                order: [[ 5, 'asc' ]],
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
                      "sEmptyTable":     "Aucune valeur disponible dans le tableau",
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

            /* $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var link = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.yes-delete-btn').attr({'href' : link})
            }) */
        });
    </script>

@endpush
