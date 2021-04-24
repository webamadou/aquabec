 <div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title font-weight-bold">Mon portefeuille</h2>
                <div class="card-tools">
                        <a href="{{route('purchase_currency')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-credit-card"></i>
                            Recharger mon portefeuille
                        </a>
                    </div>
            </div>
            <div class="card-body">
                <table class="table table-success table-striped" id="wallet-table">
                    <thead>
                        <tr>
                            <th>Monnaies</th>
                            <th>Descriptions</th>
                            <th>Montants</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->currencies as $currency)
                            <tr>
                                <td style="text-align: center">
                                    <div class="text-primary"><i class="{{$currency->icons}}"></i> <strong class="text-danger"> {{$currency->name}}</strong></div>
                                </td>
                                <td>{!! $currency->description !!}</td>
                                <td>
                                    <strong>Gratuit : {{$currency->pivot->free_currency}}</strong><br>
                                    <strong>Payant : {{$currency->pivot->paid_currency}}</strong>
                                </td>
                                <td>
                                    <a href="{{route('user.currencies.transfer', $currency->slug)}}" class="btn btn-success"><i class="fa fa-exchange-alt"></i> Transférer</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 <script defer>
    $(function() {
        $('#wallet-table').DataTable({
            order: [[ 0, 'asc' ]],
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
                    "sEmptyTable":     "Votre protfeuille est vide.",
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