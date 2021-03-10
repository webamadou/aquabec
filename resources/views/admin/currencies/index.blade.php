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
                            <textarea class="ckeditor form-control" name="description" id="description" cols="30" rows="5" placeholder="Ajoutez une description à cette monnaie">{{old('description',@$currency->description)}}</textarea>
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
                        <tbody>
                        @foreach($currencies as $currency)
                            <tr>
                                <td><i class="{{$currency->icons}} fa-lg text-primary"></i> <strong>{{$currency->name}}</strong></td>
                                <td>{!!$currency->description!!}</td>
                                <td>{{$currency->updated_at}}</td>
                                <td>
                                     <div class="btn-group dropleft">
                                        <button type="button" class="btn bg-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-primary text-bold" href="{{ route('banker.currencies.edit',$currency) }}"><i class="fa fa-user-edit"></i> Modifier</a>
                                            <a href="#" class="dropdown-item text-danger text-bold" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ route('banker.currencies.destroy',$currency) }}"><i class="fa fa-user-times"></i> Supprimer</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-primary text-bold" href="{{ route('banker.currencies.generate',$currency) }}">Générer</a>
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
    <script src="{{asset('/dist/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('/dist/ckeditor/lang/fr-ca.js')}}"></script>
    <script>
        $(function() {
            $('#roles-table').DataTable({
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