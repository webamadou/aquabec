@extends('layouts.back.admin')

@section('title','Groupes d\'age ')

@section('content')

    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.age_ramges.index')
                    <h2 class="card-title font-weight-bold">Ajouter un groupe</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.age_ramges.edit')
                    <h2 class="card-title font-weight-bold">Modifier le groupe</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'admin.settings.categories.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.age_groupe.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Groupe d'age
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-sm-12 col-md-9 ">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Groupe d'age</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="age_groupe-table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Position</th>
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
            $('#age_groupe-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/settings/get-age_ranges-data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'position', name: 'position' },
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
/* 
            $('#announcement-categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/settings/get-announcement-categories-data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'parent', name: 'parent' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            }); */

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