@extends('layouts.back.admin')

@section('title','Caractéristiques ')

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.caracteristics.index')
                    <h2 class="card-title font-weight-bold">Ajouter une caracteristic</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.caracteristics.edit')
                    <h2 class="card-title font-weight-bold">Modifier la caracteristic</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'admin.settings.caracteristics.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.caracteristics.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer une nouvelle caractéristique
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Caractéristiques des catégories</h2>
                    <div class="card-tools"><!-- <a class="btn btn-success" href="#">Ajouter des options à une caractéristique</a> --> </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="caracteristics-table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégories</th>
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
            $('#caracteristics-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                ajax: '{{ url('admin/settings/get-cateristics-data') }}',
                columns: [
                    { data: null, name: 'name',
                        render: data => {
                            //We could have done this on the model. But we want to be able to get the raw value of type some time. 
                            let type = null;
                            switch (data.type){
                                case 0: type = "Texte simple";
                                break;
                                case 1: type = `Choix unique<br><a href='/admin/settings/caracteristic/${data.id}/caracteristic_options'>Gérer les options</>`;
                                break;
                                case 2: type = `Choix multiple<br><a href='/admin/settings/caracteristic/${data.id}/caracteristic_options'>Gérer les options</>`;
                                break;

                                default: type = "Texte simple";
                            }
                            return `<h4>${data.name}</h4>${type}`;
                        }
                    },
                    { data: null, name: 'category',
                        render: data =>{
                            return `${data.category ? data.category.name:''}`;
                        }
                    },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[ 0, 'asc' ]],
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

            $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var link = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.yes-delete-btn').attr({'href' : link})
            })
        });
    </script>

@endpush
