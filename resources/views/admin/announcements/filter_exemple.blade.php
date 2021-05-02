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
                    <div class="col-sm-12 col-md-8 justify-content-start row p-0 bg-light">
                        @include("layouts.back.partials.announcements_filters")
                    </div>
                    <table class="table table-success table-striped table-borderless" id="announcements-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Region et Ville</th>
                                <th>Code postal</th>
                                <th>Categorie</th>
                                <th>Title</th>
                                <th>N°</th>
                                <th>Ajouté par</th>
                                <th>Derniere Modification</th>
                                <th>Administration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($announcements as $annc)
                                <tr>
                                    <td><a href="{{url("/admin/announcement/$annc->id")}}"><img src="{{url("/voir/images/$annc->images")}}" alt="{{@$annc->title}}" style="width:50px; height: auto"></a></td>
                                    <td><strong>Region : </strong>{{@$annc->region->name}}<br><strong>Ville : </strong>{{@$annc->city->name}}</td>
                                    <td>{{$annc->postal_code}}</td>
                                    <td>{{@$annc->category->name}}</td>
                                    <td><a href="{{url("/admin/announcement/$annc->id")}}"><small>{{$annc->title}}</small></a></td>
                                    <td>{{$annc->id}}</td>
                                    <td>{{$annc->owned->username}}</td>
                                    <td>{{$annc->updated_at}}</td>
                                    <td>Administration</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot>
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
        $(document).ready(function() {
            /* $('#announcements-table thead th').each(function() {
                var title = $(this).text();
                $(this).html(' <input type="text" placeholder="Search ' + title + '" />'+title);
            }); */
        
            var table = $('#announcements-table').DataTable({
                searchPanes: {
                    viewTotal: true
                },
                dom: 'Plriptip',
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
        
            table.columns().every( function() {
                var that = this;
        
                $('input', this.header()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });
    </script>

@endpush