@extends('layouts.back.admin')

@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des événements</h2>
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
                                <th>Identité</th>
                                <th>Organisateur</th>
                                <th>État Publication</th>
                                <th>Action</th>
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
                            /* d.date_max          = $('#filter_date_max_id').val(), */
                            d.pub_type          = $('#filter_publication_type_id').val(),
                            d.organisateur      = $('#filter_organisation_id').val(),
                            d.price_min         = $('#filter_price_min_id').val(),
                            d.region_id         = $('#filter_region_id').val(),
                            d.price_type        = $('#price_type').val(),
                            d.postal_code       = $('#filter_postal_code_id').val(),
                            d.filter_categ_id   = $('#filter_categ_id').val()
                        }
                },
                columns: [
                    { data: "id", name: 'id'},
                    { data: "title", name: 'title'},
                    { data: "dates", name: 'dates'},
                    { data: "region_id", name: 'region_id'},
                    { data: "owner", name: 'owner'},
                    { data: "organisation", name: 'organisation'},
                    /* { data:"event_time",name: "event_time" }, */
                    { data: "publication", name: 'publication'},
                    { data: 'action', name: 'action'}
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 6, 'desc' ]],
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
            /*action when select boxes are updated*/
            $('#filter_region_id, #filter_city_id, #filter_categ_id,#price_type,#filter_publication_type_id,#filter_organisation_id').change(function(){
                table.draw();
            });
            /*action when input fields are updated*/
            $('#filter_postal_code_id,#filter_price_max_id').keyup(function(){
                table.draw();
            });
            /*action when dates fields are updated*/
            $("#filter_date_min_id,#filter_date_max_id").change(function(){
                table.draw();
            });
        });
    </script>

@endpush