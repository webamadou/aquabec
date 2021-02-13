 <div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title font-weight-bold">Mon portefeuille</h2>
            </div>
            <div class="card-body">
                <table class="table table-success table-striped table-borderless" id="wallet-table">
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
                                    <h4 class="info-box-icon text-primary"><i class="{{$currency->icons}}"></i> <strong class="text-danger"> {{$currency->name}}</strong></h4>
                                </td>
                                <td>{{$currency->description}}</td>
                                <td>
                                    <strong>Gratuit : {{$currency->pivot->free_currency}}</strong><br>
                                    <strong>Payant : {{$currency->pivot->paid_currency}}</strong>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
