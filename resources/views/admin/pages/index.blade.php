@extends('layouts.back.admin')

@section('title','Gestion des pages')
@section('page_title','Gestion des pages')

@section('content')
    <div class="row">
        <div class="col-12 mb-5">
            <a href="{{route('admin.settings.pages.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter une page </a>
            <a href="{{route('admin.settings.menus.index')}}" class="btn btn-primary"><i class="fa fa-list"></i> Gérer les menus </a>
            <a href="{{route('admin.settings.menu_links.index')}}" class="btn btn-primary"><i class="fa fa-list"></i> Gérer les liens </a>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des pages</h2>
                </div>
                <div class="card-body">
                    <form class="col-sm-12 col-md-12 justify-content-center row p-0 bg-light datatable-filter mb-2">
                    <h4 class="col-12">Filtres</h4>
                        <div class="col-sm-12 col-md-2 px-0">
                            <label><small>Titre :</small><a href="#" class="reset-field" data-target="#filter_title">x</a></label>
                            <input class="form-control" id='filter_title' type="text" name="filter_title" placeholder="" />
                        </div>
                        <div class="col-sm-12 col-md-2 px-0">
                            <label><small>Type de page :</small><a href="#" class="reset-field" data-target="#filtre_page_type">x</a></label>
                            <select name="filtre_page_type" id="filtre_page_type" class="form-control">
                                <option value=""> --- </option>
                                <option value="0"> Page générique </option>
                                <option value="1"> Page Aide </option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2 px-0">
                            <label><small>Menu :</small><a href="#" class="reset-field" data-target="#menu_filter">x</a></label>
                            <select name="menu_filter" id="menu_filter" class="form-control">
                                <option value="">---</option>
                                @foreach($menus as $menu)
                                    <option value="{{$menu->id}}">{{$menu->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <table class="table table-bordered" id="pages-table">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>Type de page</th>
                                <th>Menu</th>
                                <th>Denière modification</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <!-- <tbody>
                        @foreach($pages as $key => $page)
                            <tr>
                                <td>{{$page->title}}</td>
                                <td>{{url('/')}}/pages/{{$page->slug}}</td>
                                <td>{{url('/')}}/pages/{{$page->slug}}</td>
                                <td>{{intval($page->page_type) == 1?'Page aide':'Page générique'}}</td>
                                <td>
                                    <div class="">
                                        <a class="dropdown-item text-primary text-bold" href="{{ route('admin.settings.pages.edit',$page) }}"><i class="fa fa-user-edit"></i> Modifier</a><br>
                                        <a href="#" class="dropdown-item text-danger text-bold" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ route('admin.settings.pages.destroy',$page) }}"><i class="fa fa-user-times"></i> Supprimer</a>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.back.alerts.set-page-menus')
    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script defer>
        $(function() {
            let table = $('#pages-table').DataTable({
                            processing: true,
                            ordering: true,
                            serverSide: true,
                            dom: 'Brliptip',
                            buttons: [
                                'csv', 'excel', 'pdf'
                            ],
                            ajax: {
                                url: '{{ route('admin.settings.pages.index') }}',
                                data: function (d) {
                                    d.search            = $('input[type="search"]').val(),
                                    d.city_id           = $('#filter_city_id').val(),
                                    d.date_min          = $('#filter_date_min_id').val(),
                                    d.title             = $('#filter_title').val(),
                                    d.page_type         = $('#filtre_page_type').val(),
                                    d.id                = $('#filter__id').val(),
                                    d.page_menu         = $('#menu_filter').val(),
                                    d.updated_at        = $('#filter_updated_at').val(),
                                    d.created_at        = $('#filter_created_at').val(),
                                    d.postal_code       = $('#filter_postal_code_id').val(),
                                    d.filter_categ_id   = $('#filter_categ_id').val()
                                }
                            },
                            columns: [
                                /* { data: 'id', name: 'id' }, */
                                { data: 'title', name: 'title' },
                                { data: 'page_type', name: 'page_type' },
                                { data: 'menu', name: 'menu',orderable: false },
                                { data: 'updated_at', name: 'updated_at'},
                                { data: 'action', name: 'action',orderable: false},
                            ],
                            order: [[ 3, 'desc' ]],
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
        
                $('#filtre_page_type, #filter_title,#menu_filter')
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
