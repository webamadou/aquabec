@extends('layouts.back.admin')

@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des événements @hasanyrole('admin') (admin) @endrole</h2>
                    <div class="card-tools">
                        <a href="{{route('user.create_event')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-plus"></i> Ajouter un événement
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include("layouts.front.partials.events_filters")
                    <table class="table table-success table-striped table-borderless" id="events-table">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>
                                <th>Titre</th>
                                <th>Date(s)</th>
                                <th>Région et Ville</th>
                                <th>Organisateur</th>
                                <th>Ajouté par</th>
                                <th>Ajouté le</th>
                                <th>Modifié le</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.back.alerts.validate-confirmation')
@endsection

@push('scripts')

    <script defer>
        $(function() {
            $('body').on('click','.uncolapser',function(e){
                let $id = $(this).data('item');
                //$(this).toggleClass('fa-folder-open');
                $("#date-"+$id).toggleClass("uncolapse");
            })

            let table = $('#events-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                method:'post',
                dom: 'Bfrliptip',
                ajax: {
                    url: '{{ url("admin/events") }}',
                    data: function (d) {
                            d.search            = $('input[type="search"]').val(),
                            d.city_id           = $('#filter_city_id').val(),
                            d.date_min          = $('#filter_date_min_id').val(),
                            d.filter_id         = $('#filter__id').val(),
                            d.filter__date      = $('#filter__date').val(),
                            d.pub_type          = $('#filter_publication_type_id').val(),
                            d.organisateur      = $('#filter_organisation_id').val(),
                            d.owner             = $('#annonceur_filter').val(),
                            d.filter_title      = $('#filter_title').val(),
                            d.region_id         = $('#filter_region_id').val(),
                            d.created_at        = $('#filter_created_at').val(),
                            d.updated_at        = $('#filter_updated_at').val(),
                            d.postal_code       = $('#filter_postal_code_id').val(),
                            d.filter_categ_id   = $('#filter_categ_id').val()
                        }
                },
                columns: [
                    { data: "id", name: 'id'},
                    { data: "title", name: 'title'},
                    { data: "dates", name: 'dates'},
                    { data: "region_id", name: 'region_id'},
                    { data: "organisation", name: 'organisation'},
                    { data: "owner", name: 'owner'},
                    /* { data:"event_time",name: "event_time" }, */
                    { data: "created_at", name: 'created_at'},
                    { data: "updated_at", name: 'updated_at'},
                    /* { data: 'action', name: 'action'} */
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 6, 'desc' ]],
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
                      "sEmptyTable":     "Vous n'avez aucun événement.",
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
        
                $('#filter_region_id, #filter_city_id, #filter_categ_id,#filter_title,#filter__id,#filter_updated_at,#filter_created_at,#filter_postal_code_id,#filter__date,#user_id,#filter_organisation_id,#filter_publication_type_id,#annonceur_filter__')
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
            /*action when input fields are updated*
            $('#filter_postal_code_id,#filter_price_max_id').keyup(function(){
                table.draw();
            });
            /*action when dates fields are updated*
            $("#filter_date_min_id,#filter_date_max_id").change(function(){
                table.draw();
            });*/
        });
    </script>

@endpush