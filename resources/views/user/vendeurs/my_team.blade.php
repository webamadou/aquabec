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
                    @include("layouts.back.partials.users_filters")
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
            let table = $('#teams-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Brliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                ajax: {
                    url: '{{ route("vendeurs.my_team") }}',
                    data: function (d) {
                        d.search            = $('input[type="search"]').val(),
                        d.filter_name       = $('#filter_name').val(),
                        d.filter_prenom     = $('#filter_prenom').val(),
                        d.filter_username   = $('#filter_username').val(),
                        d.filter_roles      = $('#filter_roles').val(),
                        d.filter_id         = $('#filter_id').val(),
                        d.filter_email      = $('#filter_email').val(),
                        d.updated_at        = $('#filter_updated_at').val(),
                        d.created_at        = $('#filter_created_at').val()
                    }
                },
                columns: [
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' }
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

            /** loading filters when fields value changed **/
            table.columns().every( function() {
                var that = this;

                $('#filter_id,#filter_prenom, #filter_name, #filter_username,#filter_roles,#filter_email')
                .on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
                //When the button to reset a filter is clicked
                $('body').on('click','.reset-field', function (e) {
                    e.preventDefault();
                    console.log("hello");
                    const target = $(this).data('target');
                    $(target).val('')
                    that.draw();
                });
                //When the button to erase filters is clicked
                $('body').on('click','#reset_filter', function (e) {
                    e.preventDefault();
                    $('form.datatable-filter')[0].reset();
                    that.search(this.value).draw();
                });
            });
        });
    </script>

@endpush
