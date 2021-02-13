@extends('layouts.back.admin')

@section('title','Liste des monnaies')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'banker.currencies.index')
                        <h2 class="card-title font-weight-bold">Ajouter une monnaie</h2>
                    @endif
                    @if(Route::currentRouteName() == 'banker.currencies.edit')
                        <h2 class="card-title font-weight-bold">Modifier la monnaie</h2>
                    @endif
                </div>
                <div class="card-body">
                    @if(Route::currentRouteName() == 'banker.currencies.edit')
                    <form method="POST" action="{{route('banker.currencies.update', @$currency)}}" accept-charset="UTF-8">
                        @method('PUT')
                    @else
                    <form method="POST" action="{{route('banker.currencies.store')}}" accept-charset="UTF-8">
                    @endif
                        @csrf
                        <input class="form-control" name="created_by" type="hidden" value="{{$user->id}}">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group" data-children-count="1">
                            <label for="name" class="control-label">Le nom de la monnaie</label>
                            <input class="form-control" name="name" type="text" id="name" value="{{old('name',@$currency->name)}}">
                        </div>
                        <div class="form-group" data-children-count="1">
                            <label for="icons" class="control-label">L'icone de la monnaie</label>
                            <input class="form-control" name="icons" type="hidden" id="icons" value="{{old('icons',@$currency->icons)}}">
                            <div id="icons-picker"></div>
                        </div>
                        <div class="form-group" data-children-count="1">
                            <label for="description" class="control-label">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5" placeholder="Ajoutez une description à cette monnaie">{{old('description',@$currency->description)}}</textarea>
                        </div>
                        <button class="btn bg-primary float-right" type="submit"><i class="fa fa-save mr-2"></i>Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des monnaies</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="roles-table">
                        <thead>
                        <tr>
                            <th>Monnaie</th>
                            <th>Description</th>
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
                ajax: '{{ url('banker/get-currencies-data') }}',
                columns: [
                    /* { data: 'icons', name: 'icons' }, */
                    { data: null, name: 'icons',
                        render: data => { return `<i class="${data.icons} fa-lg text-primary"></i> <strong>${data.name}</strong>`; }
                    },
                    { data: 'description', name: 'description' },
                    { data: null, name: 'updated_at',
                        render: data => { return `<span class="tiny-text">${data.updated_at}</span>`; }
                    },
                    /* { data: 'updated_at', name: 'updated_at' }, */
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[ 0, 'asc' ]],
                pageLength: 100,
                responsive: true,
                "oLanguage":{
                      "sProcessing":     "<i class='fa fa-2x fa-spinner fa-pulse'>",
                      "sSearch":         "Rechercher&nbsp;:",
                      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                      "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                      "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
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

            /*folowing script will update the value of the icon field when iconpicker is set*/
            $(document).ready(function() {
                $('#icons-picker').iconpicker({
                    align: 'center', // Only in div tag
                    arrowClass: 'btn-danger',
                    arrowPrevIconClass: 'fas fa-angle-left',
                    arrowNextIconClass: 'fas fa-angle-right',
                    setSearch: false
                })
                .iconpicker('setAlign', 'center') // Only in div tag
                .iconpicker('setArrowClass', 'btn-success')
                .iconpicker('setArrowPrevIconClass', 'fas fa-angle-left')
                .iconpicker('setArrowNextIconClass', 'fas fa-angle-right')
                .iconpicker('setCols', 7)
                .iconpicker('setSearchText', `{{@$currency->icons}}`)
                .on('change', function(e) {
                    $("#icons").val(e.icon);
                });
            });
        });
    </script>

@endpush