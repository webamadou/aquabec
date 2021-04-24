@extends('layouts.back.admin')

@section('title','Liste des monnaies')

@inject('credit', 'App\Models\Credit')
@section('content')
    <div class="row">
        <div class="col-12 mb-5">
            <a href="{{route('banker.currencies.index')}}" class="btn btn-primary">Enregistrer une nouvelles monnaie</a>
        </div>
        <div class="col-sm-10 mx-auto">
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
                                <td>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>Valeur Gratuite</small>
                                        <span class="badge bg-primary rounded-pill">{{$credit->formatCredit(@$currency->pivot->free_currency ?: 0)}}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small>Valeur payante</small>
                                        <span class="badge bg-primary rounded-pill">{{$credit->formatCredit(@$currency->pivot->paid_currency ?: 0)}}</span>
                                    </div>
                                    {!!$currency->description!!}
                                </td>
                                <td>{{$currency->updated_at}}</td>
                                <td>
                                     <div class="btn-group dropleft">
                                        <button type="button" class="btn bg-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item text-primary text-bold" href="{{ route('banker.currencies.edit',$currency) }}"><i class="fa fa-user-edit"></i> Modifier</a>
                                            <a class="dropdown-item text-primary text-bold" href="{{ route('banker.currencies.generate',$currency) }}"><i class="fa fa-plus-circle"></i> Générer</a>
                                            <a class="dropdown-item text-primary text-bold" href="{{ route('banker.currencies.transfer',$currency) }}"><i class="fa fa-share-square"></i> Transférer</a>

                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item text-danger text-bold" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ route('banker.currencies.destroy',$currency) }}"><i class="fa fa-user-times"></i> Supprimer</a>
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
    <!-- @ foreach($currencies as $currency)
        <div class="col-md-6 col-sm-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="{{$currency->icons}}"></i></span>
                <div class="info-box-content">
                    <h3>{{$currency->name}}</h3>
                    <div class="tiny-text mb-3"> {!!$currency->description!!}</div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valeur Gratuite
                            <span class="badge bg-primary rounded-pill">{{$credit->formatCredit(@$currency->pivot->free_currency ?: 0)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valeur payante
                            <span class="badge bg-primary rounded-pill">{{$credit->formatCredit(@$currency->pivot->paid_currency ?: 0)}}</span>
                        </li>
                    </ul>
                    <p class="my-4">
                        <a href="{{route('banker.currencies.generate',$currency)}}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-square"></i> Générer
                        </a>
                        <a href="{{route('banker.currencies.transfer',$currency)}}" class="btn btn-light btn-sm">
                            <i class="fas fa-share-square"></i> Transférer
                        </a>
                        <a href="{{route('banker.currencies.edit',$currency)}}" class="btn btn-success btn-sm">
                            <i class="far fa-edit"></i> Éditer
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @ endforeach -->
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
                dom: 'Bfrliptip',
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