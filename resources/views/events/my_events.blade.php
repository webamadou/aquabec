@extends('layouts.front.app')

@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Mes évènements</h2>
                    <div class="card-tools">
                        <a href="{{route('user.create_event')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-plus"></i> Ajouter un évènement
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-success table-striped table-borderless" id="events-table">
                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Categorie</th>
                                <th>Dates</th>
                                <th>Proprietaire</th>
                                <th>Region et Ville</th>
                                <th>Date d'envoie</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script defer>
        $(function() {
           $('#events-table').DataTable({
                processing: true,
                serverSide: true,
                method:'post',
                ajax: '{{ route("user.myEvents-data") }}',
                columns: [
                    { data: null, name: 'title',
                        render : data => {
                            const title = (data.title.length > 35) ? `${data.title.substring(0,35)}...` :data.title;
                            return `<img src="/show/images/${data.images}" alt="{{@$event->title}}" style="width:50px; height: auto"><br><strong><a href="/mes_evenements/event/${data.slug}">${title}</a></strong>`;
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
                            const dates = data.dates.split(',');
                            for(let i = 0; i < dates.length; i++){
                                formated_dates += `<span class="badge badge-primary text-sm d-block my-1"> ${dates[i]} </span> ` ;
                            }
                            return formated_dates;
                        }
                    },
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
                            switch (data.publication_status) {
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
                    }
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[ 5, 'desc' ],[0,'asc']],
                pageLength: 100,
                responsive: true,
                "oLanguage":{
                      "sProcessing":     "<i class='fa fa-2x fa-spinner fa-pulse'>",
                      "sSearch":         "Rechercher&nbsp;:",
                      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
                      "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                      "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
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