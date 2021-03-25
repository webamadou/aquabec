@extends('layouts.back.admin')
@section('title','Liste des événements')

@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Mes événements</h2>
                    <div class="card-tools">
                        <a href="{{route('user.create_event')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-plus"></i> Ajouter un événement
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-success table-striped table-borderless" id="events-table">
                        <thead class="table-light">
                            <tr>
                                <th>-</th>
                                <th>Titre</th>
                                <th>Categorie</th>
                                <th>Dates</th>
                                <th>Heure</th>
                                <th>Proprietaire</th>
                                <th>Region et Ville</th>
                                <th>Date d'enregistrement</th>
                                <th>Status</th>
                                <th>Actions</th>
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
           $('#events-table').DataTable({
                processing: true,
                serverSide: true,
                method:'post',
                dom: 'Bfrliptip',
                ajax: '{{ route("admin.myEvents-data") }}',
                columns: [
                    {data: null, name: 'id',
                        render: data => {
                            let id = data.id;
                            return id > 99 ? id : ("00" + id).slice(-6);
                        }
                    },
                    { data: null, name: 'title',
                        render : data => {
                            const title = (data.title.length > 35) ? `${data.title.substring(0,35)}...` :data.title;
                            return `<strong><a href="/admin/event/${data.id}">${title}</a></strong>`;
                        }
                    },
                    { data: null, name: 'category_id',
                        render : data => {
                            return `${data.category?data.category.name:""}`;
                        }
                    },
                    { data: null, name: 'dates',
                        render : data => {
                            let formated_dates = '';
                            const dates = data.dates?data.dates.split(','):[data.dates];
                            for(let i = 0; i < dates.length; i++){
                                formated_dates += `<span class="badge badge-primary text-sm d-block my-1"> ${dates[i]} </span> ` ;
                            }
                            return formated_dates;
                        }
                    },
                    { data:"event_time",name: "event_time" },
                    { data: null, name: 'owner',
                        render : data => {
                            let retour = `${data.owned?data.owned.name:""}`;
                            if(data.owned.id !== data.posted.id)
                                retour += `<br><strong> Postée par : ${data.posted.name}</strong>`;

                            return `${retour}`
                        }
                    },
                    { data: null, name: 'region_id',
                        render: data => {
                            return `<strong>Region : </strong>${data.region?data.region.name:""}<br><strong>Ville : </strong>${data.city?data.city.name:""}`;
                        }
                    },
                    { data: null, name: 'updated_at',
                        render: data => {
                            let annonce_status = '';
                            switch (parseInt(data.publication_status)) {
                                case 0:
                                    annonce_status = `<span class="badge badge-warning">Bouillon</div>`  ;
                                    break;
                                case 1:
                                    annonce_status = `<span class="badge badge-success">Publiée</div>`  ;
                                    break;
                                case 2:
                                    annonce_status = `<span class="badge badge-primary">Privée</div>`  ;
                                    break;
                                case 4:
                                    annonce_status = `<span class="badge badge-danger">Suprimée</div>`  ;
                                    break;
                            
                                default:
                                    break;
                            }
                            return `${data.updated_at} <br> ${annonce_status}`
                        }
                    },
                    {data: null, name: 'validated',
                        render: data => {
                            let validated = '';
                            switch (data?.validated) {
                                case 0:{
                                    return `<span class="badge badge-primary">En attente</span>`
                                    break;
                                }
                                case 1:{
                                    return `<span class="badge badge-success">Validée</span>`
                                    break;
                                }
                                case 2:{
                                    return `<span class="badge badge-danger">Rejetée</span>`
                                    break;
                                }
                                case 3:{
                                    return `<span class="badge badge-danger">Supprimée</span>`
                                    break;
                                }

                                default:{
                                    return ""
                                    break;
                                }
                            }
                            return data.validated
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '80' }
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 8, 'asc' ],[7, 'desc']],
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
                      "sEmptyTable":     "Vous n'avez pas encore de transaction.",
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
        });
    </script>

@endpush