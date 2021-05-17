@extends('layouts.back.admin')

@section('title','Gestion des liens des menus')
@section('page_title','Gestion des liens des menus')

@section('content')
    <div class="row">
        <div class="col-12 mb-5">
            <a href="{{route('admin.settings.menus.index')}}" class="btn btn-primary"><i class="fa fa-list"></i> Gérer les menus </a>
            <a href="{{route('admin.settings.pages.index')}}" class="btn btn-primary"><i class="fa fa-list"></i> Gérer les pages </a>
        </div>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.menu_links.index')
                        <h2 class="card-title font-weight-bold">Ajouter un lien</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.menu_links.edit')
                        <h2 class="card-title font-weight-bold">Modifier le lien</h2>
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
                    <h2 class="card-title font-weight-bold">Liste des liens</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="pages-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>url</th>
                                <th>menu</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $menu)
                            <tr>
                                <td>{{$menu->name}}</td>
                                <td>{{url('/pages/'.@$menu->page->slug)}}</td>
                                <td>{{@$menu->menu->name}}</td>
                                <td>Actions</td>
                            </tr>
                        @endforeach
                        </tbody>
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
            $('#pages-table').DataTable({
                processing: false,
                serverSide: true,
                dom: 'Bfrliptip',
                ajax: '{{ route('admin.settings.menulinks.data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: null, name: 'page_id',
                        render: data => {
                            return `<a href="${data.url}" target="_blank">${data.page?data.page.title:"Aucune page"}</a>`;
                        }
                    },
                    { data: null, name: 'menu_id',
                        render: data => {
                            return `${data.menu_id?data.menu_id.name:"Aucun menu"}`;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 0, 'asc' ]],
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
