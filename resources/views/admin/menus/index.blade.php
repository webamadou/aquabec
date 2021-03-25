@extends('layouts.back.admin')

@section('title','Gestion des pages')

@section('content')
    <div class="row">
        <div class="col-12 mb-5">
            <a href="{{route('admin.settings.pages.index')}}" class="btn btn-primary"><i class="fa fa-list"></i> Gestion des pages </a>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.menus.index')
                        <h2 class="card-title font-weight-bold">Ajouter un menu</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.menus.edit')
                        <h2 class="card-title font-weight-bold">Modifier le menu</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des pages</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="pages-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Visible</th>
                                <th>Role</th>
                                <th>Public</th>
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

    <script src="{{asset('/dist/ckeditor/ckeditor.js')}}" defer></script>
    <script>
        $(function() {
            $('#pages-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                ajax: '{{ route('admin.settings.menus.data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: null, name: 'visible',
                        render: data => {
                            switch (parseInt(data.visible)) {
                                case 1:
                                    return "Menu visible";
                                    break;
                            
                                default:
                                    return "Menu caché";
                                    break;
                            }
                            return "";
                        }
                    },
                    { data: 'roles', name: 'roles' },
                    { data: null, name: 'public',
                        render: data => {
                            switch (parseInt(data.public)) {
                                case 1:
                                    return "Menu public";
                                    break;
                            
                                default:
                                    return "Menu privé";
                                    break;
                            }
                        } 
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 2, 'asc' ]],
                pageLength: 25,
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
