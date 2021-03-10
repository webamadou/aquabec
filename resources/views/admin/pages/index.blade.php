@extends('layouts.back.admin')

@section('title','Gestion des pages')

@section('content')
    <div class="row">
        <div class="col-12 mb-5">
            <a href="{{route('admin.settings.pages.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i>Ajouter une page </a>
            <a href="{{route('admin.settings.create_section')}}" class="btn btn-primary"><i class="fa fa-plus"></i>Ajouter une section </a>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des pages</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="pages-table">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>url</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $key => $page)
                            <tr>
                                <td>{{$page->title}}</td>
                                <td>{{url('/')}}/pages/{{$page->slug}}</td>
                                <td>
                                    <div class="btn-group dropleft">
                                        <a class="dropdown-item text-primary text-bold" href="{{ route('admin.settings.pages.edit',$page) }}"><i class="fa fa-user-edit"></i> Modifier</a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des sections</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="sections-table">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pagesection as $key => $page)
                            <tr>
                                <td>{{$page->title}}</td>
                                <td>
                                    <div class="btn-group dropleft">
                                        <a class="dropdown-item text-primary text-bold" href="{{ route('admin.settings.edit_section',$page) }}"><i class="fa fa-user-edit"></i> Modifier</a>
                                    </div>

                                </td>
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

    <script src="{{asset('/dist/ckeditor/ckeditor.js')}}" defer></script>
    <script>
        $(function() {
            $('#pages-table').DataTable({
                processing: true,
                serverSide: false,
                /* ajax: '{{ route('admin.settings.pages.data') }}',
                columns: [
                    { data: 'ref', name: 'ref' },
                    { data: null, name: 'content',
                        render: data => { 
                            const site_url = '{{url('/')}}';
                            return `${site_url}/${data.slug}`;
                        }
                    },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ], */
                order: [[ 2, 'asc' ]],
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
            
            $('#sections-table').DataTable({
                processing: true,
                serverSide: false,
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
        });
    </script>

@endpush
