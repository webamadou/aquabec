@extends('layouts.back.admin')

@section('title',"Liste des annonces")
@section('page_title','Liste des annnonces')

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
                    <form class="col-sm-12 col-md-12 justify-content-center row p-0 bg-light datatable-filter">
                        @include("layouts.back.partials.announcements_filters")
                    </form>
                    <table class="table table-success table-striped table-borderless" id="announcements-table">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Titre</th>
                                <th>Region et Ville</th>
                                <th>Categorie</th>
                                <th>Code postal</th>
                                <th>Ajouté par</th>
                                <th>Date de l'ajout</th>
                               <!--  <th>Action</th> -->
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
                                    d.title             = $('#filter_title').val(),
                                    d.pub_type          = $('#filter_publication_type_id').val(),
                                    d.id                = $('#filter__id').val(),
                                    d.region_id         = $('#filter_region_id').val(),
                                    d.updated_at        = $('#filter_updated_at').val(),
                                    d.created_at        = $('#filter_created_at').val(),
                                    d.postal_code       = $('#filter_postal_code_id').val(),
                                    d.filter_categ_id   = $('#filter_categ_id').val()
                                }
                            },
                            columns: [
                                { data: 'id', name: 'id' },
                                { data: 'title', name: 'title' },
                                { data: 'region_id', name: 'region_id' },
                                { data: 'category_id', name: 'category_id' },
                                { data: 'postal_code', name: 'postal_code' },
                                { data: 'owner', name: 'owner' },
                                { data: 'updated_at', name: 'updated_at'},
                                /* { data: 'action', name: 'action'}, */
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
            table.columns().every( function() {
                var that = this;
        
                $('#filter_region_id, #filter_city_id, #filter_categ_id,#filter_title,#filter__id,#filter_updated_at,#filter_created_at,#filter_postal_code_id')
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

            /*action when select boxes are updated*
            $('#filter_region_id, #filter_city_id, #filter_categ_id,#price_type,#filter_publication_type_id').change(function(){
                table.draw();
            });
            /*action when input fields are updated*
            $('#filter_postal_code_id,#filter_price_min_id,#filter_price_max_id').keyup(function(){
                table.draw();
            });
            /*action when dates fields are updated*
            $("#filter_date_min_id,#filter_date_max_id").blur(function(){
                table.draw();
            });*/

        });
    </script>

@endpush