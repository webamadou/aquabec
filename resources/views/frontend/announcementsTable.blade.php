@extends('layouts.front.master')

@section('title','Bienvenus')

@section('content')
    <section id="tw-blog" class="tw-blog">
        <div class="container">
            <div class="row text-center">
                <div class="col section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay=".5s">
                    <h2>
                        <small>Annonce </small>
                        <span>Catégorie / {{@$category->name}}</span>
                    </h2>
                    <span class="animate-border border-offwhite ml-auto mr-auto tw-mt-20"></span>
                </div>
                <!-- Col end -->
            </div>
            <!-- Row End -->
            <div class="row fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                <div class="col-sm-12 col-md-12" id="list-component-wrapper">
                    @include("frontend.includes.announcements_filters")
                    <table class="table table-primary table-striped table-borderless" id="announcements-table">
                        <thead class="table-light">
                            <tr>
                                <th>Images</th>
                                <th>Titre</th>
                                <th>Categorie</th>
                                <th>Prix</th>
                                <th>Identité</th>
                                <th>Region & Ville</th>
                                <th>Publiée le</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
            // Create our number formatter.
            var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            });

            let table = $('#announcements-table').DataTable({
                            processing: true,
                            ordering: true,
                            serverSide: true,
                            dom: 'Brliptip',
                            buttons: [
                                // 'csv', 'excel', 'pdf'
                            ],
                            ajax: {
                                url: '{{ route("announcement_page",$category) }}',
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
                                { data: 'images', name: 'images' },
                                { data: 'title', name: 'title' },
                                { data: 'category_id', name: 'category_id' },
                                { data: 'price', name: 'price' },
                                { data: 'owner', name: 'owner' },
                                { data: 'region_id', name: 'region_id' },
                                { data: 'published_at', name: 'published_at'},
                            ],
                            order: [[ 0, 'asc' ]],
                            pageLength: 25,
                            responsive: true,
                            columnDefs: [
                                { responsivePriority: 1, targets: 0 },
                                { responsivePriority: 2, targets: 1 },
                                { responsivePriority: 3, targets: 2 },
                                { responsivePriority: 4, targets: 3 },
                                { responsivePriority: 5, targets: 4 },
                                { responsivePriority: 6, targets: 5 },
                                { responsivePriority: 7, targets: -1 },
                            ],
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

            $('.dt-buttons').append(' <button class="dt-button buttons-csv buttons-html5 btn btn-success m-0" tabindex="0" aria-controls="announcements-table" type="button" id="reset_filter"><span><i class="fa fa-broom"></i>Effacer les filtres</span></button>')
        });
    </script>
@endpush
