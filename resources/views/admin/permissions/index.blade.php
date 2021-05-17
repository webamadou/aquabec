@extends('layouts.back.admin')

@section('title','Permissions')
@section('page_title','Permissions')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.security.permissions.index')
                        <h2 class="card-title font-weight-bold">Ajouter une permission</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.security.permissions.edit')
                        <h2 class="card-title font-weight-bold">Modifier la permission</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'admin.settings.security.permissions.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.security.permissions.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer une nouvelle permission
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des permissions</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="roles-table">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Roles</th>
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
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                ajax: '{{ url('admin/settings/security/get-permission-data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'roles', name: 'roles' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[ 1, 'asc' ]],
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
        });
    </script>

@endpush
