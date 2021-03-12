@extends('layouts.back.admin')

@section('title','Les options de la caractéristique '.@$caracteristic->name)

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.caracteristicOption')
                    <h2 class="card-title font-weight-bold">Ajouter une option</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.edit_caracteristicOption')
                    <h2 class="card-title font-weight-bold">Modification d'une option</h2>
                    @endif
                </div>
                <div class="card-body">
                @if(Route::currentRouteName() == 'admin.settings.caracteristicOption')
                    <form method="POST" action="{{route('admin.settings.store_caracteristicOption',$caracteristic->id)}}">
                    <input type="hidden" name="caracteristic_id" id="caracteristic_id" value="{{$caracteristic->id}}">
                @endif
                @if(Route::currentRouteName() == 'admin.settings.edit_caracteristicOption')
                    <form method="POST" action="{{route('admin.settings.update_caracteristicOption',[$option])}}">
                    @method('put')
                    <input type="hidden" name="caracteristic_id" id="caracteristic_id" value="{{$option->caracteristic_id}}">
                @endif
                        @csrf
                        <div class="form-group" data-children-count="1"> 
                            <label for="name" class="control-label required">Nom de l'option *</label>
                            <input class="form-control" required="required" name="name" type="text" id="name" value="{{@$option->name}}">
                        </div> 
                        <button class="btn bg-primary float-right" type="submit"><i class="fa fa-save mr-2"></i>Enregistrer</button> 
                    </form>
                </div>
                @if(Route::currentRouteName() == 'admin.settings.caracteristic_options.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.caracteristics.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Ajouter une option
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
                            <th>Caracteristic</th>
                            <th>Dernière modification</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($options as $key => $option)
                            <tr>
                                <td><h4>{{$option->name}}</h4></td>
                                <td><strong>{{$option->caracteristic->name}}</strong></td>
                                <td>{{$option->updated_at}}</td>
                                <td>
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn bg-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-primary text-bold" href="{{ route('admin.settings.edit_caracteristicOption',[$option->caracteristic_id,$option->id]) }}"><i class="fa fa-user-edit"></i> Modifier</a>
                                            <a href="#" class="dropdown-item text-danger text-bold" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ route('admin.settings.delete_caracteristicOption',[$option->id]) }}"><i class="fa fa-user-times"></i> Supprimer</a>
                                        </div>
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

    <script>
        $(function() {
            $('#caracteristics-table').DataTable({
                processing: true,
                /* serverSide: true,
                ajax: '{ { url('admin/settings/get-cateristic-options-data',$id) }}',
                columns: [
                    { data: null, name: 'name',
                        render: data => {
                            return `<h4>${data.name}</h4>`;
                        }
                    },
                    { data: null, name: 'category',
                        render: data =>{
                            return `${data.caracteristic ? data.caracteristic.name:''}`;
                        }
                    },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ], */
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
