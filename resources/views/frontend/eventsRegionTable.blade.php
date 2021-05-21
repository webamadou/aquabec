@extends('layouts.front.master')

@section('title','Bienvenus')

@section('content')
    <section id="tw-blog" class="tw-blog">
        <div class="container">
            <div class="row text-center">
                <div class="col section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay=".5s">
                    <h2>
                        <small>Evénements</small>
                        <span>{{$region->name}}</span>
                    </h2>
                    <span class="animate-border border-offwhite ml-auto mr-auto tw-mt-20"></span>
                </div>
                <!-- Col end -->
            </div>
            <!-- Row End -->
            <div class="row fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                <div class="col-sm-12 col-md-12" id="list-component-wrapper">
                    @include("frontend.includes.events_filters")
                    <table class="table table-primary table-striped table-borderless" id="events-table">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Titre</th>
                                <th>Dates</th>
                                <th>Region & Ville</th>
                                <th>Ajouté par</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                    
                <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#" class="btn btn-primary btn-lg tw-mt-80">view all</a></div> -->
            </div>
            <!-- End Row -->
        </div>
        <!-- Container End -->
    </section>
    <!-- template tag -->
@stop

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
                dom: 'Brliptip',
                method:'post',
                ajax: {
                    url: '{{ route("event_region",$region) }}',
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
                    { data: "images", name: 'images'},
                    { data: "title", name: 'title'},
                    { data: "dates", name: 'dates'},
                    { data: "region_id", name: 'region_id'},
                    { data: "owner", name: 'owner'},
                ],
                buttons: [
                    /* 'csv', 'excel', 'pdf' */
                ],
                order: [[ 5, 'desc' ]],
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
            table.columns().every( function() {
                var that = this;
        
                $('#filter_region_id, #filter_city_id, #filter_categ_id,#filter_title,#filter__id,#filter_updated_at,#filter_created_at,#filter_postal_code_id,#filter__date,#user_id,#filter_organisation_id,#filter_publication_type_id,#annonceur_filter')
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

            $('.dt-buttons').append(' <button class="dt-button buttons-csv buttons-html5 btn btn-success m-0" tabindex="0" aria-controls="announcements-table" type="button" id="reset_filter"><span><i class="fa fa-broom"></i>Effacer les filtres</span></button>')
        });
    </script>
@endpush
