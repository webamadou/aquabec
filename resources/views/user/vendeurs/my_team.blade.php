@extends('layouts.front.app')

@section('title','Mon Équipe')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold"> - </h2>
                    <div class="card-tools">
                        <a href="{{route('vendeurs.create_vendeur')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-user-plus"></i>
                            Ajouter un nouveau membre d'équipe
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-success table-striped table-borderless" id="teams-table">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Enregistré le</th>
                                <th>Action</th>
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
            $('#teams-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                ajax: '{{ route("vendeurs.my_team_data") }}',
                columns: [
                    { data: null, name: 'name',
                        render: data => {
                            const slug      = data.slug ?? '';
                            const prenom    = data.prenom ?? '';
                            const name      = data.name ?? '';
                            return data.name?`<strong><i class="fa fa-user-friends"><a href="{{url('/vendeur/${slug}')}}"> ${prenom} ${name}</a></strong>`:``;
                        }
                    },
                    { data: 'email', name: 'email'},
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' }
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 0, 'desc' ]],
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
                      "sEmptyTable":     "Votre équipe est vide pour le moments.",
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
