@extends('layouts.front.app')

@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Mes annonces</h2>
                    <div class="card-tools">
                        <a href="{{route('user.create_announcement')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-plus"></i> Ajouter une annonce
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label><strong>Regions :</strong></label>
                        <select id='filter_region_id' class="form-control" style="width: 200px">
                            <option value="">--Filtrer par region--</option>
                            @foreach(@$regions as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <table class="table table-success table-striped table-borderless" id="announcements-table">
                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Categorie</th>
                                <th>Prix</th>
                                <th>Identité</th>
                                <th>Region et Ville</th>
                                <th>Etat Publication</th>
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
            // Create our number formatter.
            var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            });


           $('#announcements-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                method:'post',
                dom: 'Bfrliptip',
                ajax: '{{ route("user.myAnnouncements-data") }}',
                columns: [
                    { data: null, name: 'title',
                        render : data => {
                            const title = (data.title.length > 35) ? `${data.title.substring(0,35)}...` :data.title;
                            return `<a href="/mes_annonces/announcement/${data.slug}"><img src="/voir/images/${data.images}" alt="{{@$announcement->title}}" style="width:50px; height: auto"><br><strong>${title}</strong></a>`;
                        }
                    },
                    { data: null, name: 'category_id',
                        render : data => {
                            return `${data.category?data.category.name:""}`;
                        }
                    },
                    { data: null, name: 'price',
                        render : data => {
                            const prix = data?.price_type == 1? `${formatter.format(data.price)}`:(data?.price_type == 3?"Échange":"Gratuit");
                            return prix;
                        }
                    },
                    { data: null, name: 'owner',
                        render : data => {
                            let retour = `${data.owned?data.owned.username:""}`;
                            if(data.owned.id !== data.posted.id)
                                retour += `<br><strong> Postée par : ${data.posted.username}</strong>`;

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
                                    annonce_status = `<h1 class="text-md badge badge-warning font-bold">Bouillon</h1>`;
                                    break;
                                case 1:
                                    annonce_status = `<h1 class="text-md badge badge-success font-bold">Publiée</h1>`;
                                    break;
                                case 2:
                                    annonce_status = `<h1 class="text-md badge badge-primary font-bold">Privée</h1>`;
                                    break;
                                case 4:
                                    annonce_status = `<h1 class="text-md badge badge-danger font-bold">Suprimée</h1>`;
                                    break;
                            
                                default:
                                    break;
                            }
                            return parseInt(data.lock_publication) == 1 ? '<span class="badge badge-warning"><i class="fa fa-ban"></i> Publication bloquée</span>':`${annonce_status}`;
                        }, width: '40'
                    }
                ],
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
                order: [[ 4, 'desc' ]],
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
                      "sEmptyTable":     "Vous n'avez aucune annonce.",
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