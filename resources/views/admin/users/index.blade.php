@extends('layouts.back.admin')

@section('title','Liste des utilisateurs ')
@section('page_title','Liste des utilisateurs ')

@section('content')

    <div class="row">
        <div><a href="{{route('admin.users.create')}}" class="btn btn-primary mb-4 mb-4"><i class="fa fa-user-plus"></i> Inscrire un équipier </a></div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des utilisateurs</h2>
                </div>
                <div class="card-body">
                    @include("layouts.back.partials.users_filters")
                    <table class="table table-bordered" id="event-users-table">
                        <thead>
                        <tr>
                            <th> - </th>
                            <th>Nom & Prénom</th>
                            <th>Adresse Email</th>
                            <th>Fonctions</th>
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
            let table = $('#event-users-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Brliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                ajax: {
                    url: '{{ url('/admin/users') }}',
                    data: function (d) {
                        /* $('#filter_prenom, #filter_name, #filter_username,#filter_roles') */
                        d.search            = $('input[type="search"]').val(),
                        d.filter_name       = $('#filter_name').val(),
                        d.filter_prenom     = $('#filter_prenom').val(),
                        d.filter_username   = $('#filter_username').val(),
                        d.filter_roles      = $('#filter_roles').val(),
                        d.filter_id         = $('#filter_id').val(),
                        d.region_id         = $('#filter_region_id').val(),
                        d.updated_at        = $('#filter_updated_at').val(),
                        d.created_at        = $('#filter_created_at').val(),
                        d.postal_code       = $('#filter_postal_code_id').val(),
                        d.filter_categ_id   = $('#filter_categ_id').val()
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email' },
                    { data: 'roles', name: 'roles'},
                    { data: 'updated_at', name: 'updated_at', width: '150' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '80' }
                ],
                order: [[ 5, 'asc' ]],
                pageLength: 30,
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

            /** loading filters when fields value changed **/
            table.columns().every( function() {
                var that = this;

                $('#filter_id,#filter_prenom, #filter_name, #filter_username,#filter_roles')
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
            /* $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var link = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.yes-delete-btn').attr({'href' : link})
            }) */
        });
    </script>

@endpush
