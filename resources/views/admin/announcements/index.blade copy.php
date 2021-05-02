@extends('layouts.back.admin')

@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des annonces</h2>
                    <div class="card-tools">
                        <a href="{{route('admin.create_announcement')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-plus"></i> Ajouter une annonce
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include("layouts.front.partials.announcements_filters")
                    <table class="table table-success table-striped table-borderless" id="announcements-table">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Titre</th>
                                <th>Categorie</th>
                                <th>Prix</th>
                                <th>Identité</th>
                                <th>Region et Ville</th>
                                <th>Etat Publication</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div id="HoursPickupModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Veuillez sélectionner les heures pour chaque dates</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="/membres/send_registration" method="post" accept-charset="utf-8">
                        <div class="form-group hourselection row">
                            <label for="username" class="col-sm-4  control-label">Heure pour tous: </label>
                            <div class="col-sm-3 input-group clockpickerall" data-placement="left" data-align="top" data-autoclose="true">
                                <input type="text" class="form-control " value="09:30">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                        <div id="themodal"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary SaveFinalDate">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.back.alerts.validate-confirmation')
@endsection

@push('scripts')

    <script defer>
        $(function() {
            // Create our number formatter.
            var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            });

            let table = $('#announcements-table').DataTable({
                            processing: true,
                            ordering: true,
                            serverSide: true,
                            dom: 'Bfrliptip',
                            buttons: [
                                'csv', 'excel', 'pdf'
                            ],
                            ajax: {
                                url: '{{ url('admin/announcements') }}',
                                data: function (d) {
                                    d.search            = $('input[type="search"]').val(),
                                    d.city_id           = $('#filter_city_id').val(),
                                    d.date_min          = $('#filter_date_min_id').val(),
                                    d.date_max          = $('#filter_date_max_id').val(),
                                    d.pub_type          = $('#filter_publication_type_id').val(),
                                    d.price_max         = $('#filter_price_max_id').val(),
                                    d.price_min         = $('#filter_price_min_id').val(),
                                    d.region_id         = $('#filter_region_id').val(),
                                    d.price_type        = $('#price_type').val(),
                                    d.postal_code       = $('#filter_postal_code_id').val(),
                                    d.filter_categ_id   = $('#filter_categ_id').val()
                                }
                            },
                            columns: [
                                { data: 'id', name: 'id' },
                                { data: 'title', name: 'title' },
                                { data: 'category_id', name: 'category_id' },
                                { data: 'price', name: 'price' },
                                { data: 'owner', name: 'owner' },
                                { data: 'region_id', name: 'region_id' },
                                { data: 'publication', name: 'publication'},
                                { data: 'action', name: 'action'},
                            ],
                            order: [[ 0, 'asc' ]],
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
            /*action when select boxes are updated*/
            $('#filter_region_id, #filter_city_id, #filter_categ_id,#price_type,#filter_publication_type_id').change(function(){
                table.draw();
            });
            /*action when input fields are updated*/
            $('#filter_postal_code_id,#filter_price_min_id,#filter_price_max_id').keyup(function(){
                table.draw();
            });
            /*action when dates fields are updated*/
            $("#filter_date_min_id,#filter_date_max_id").blur(function(){
                table.draw();
            });

        });
    </script>

@endpush