@extends('layouts.front.app')

@section('title','')

@inject('credit', 'App\Models\Credit')
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Recharge de mon portefeuile</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('process_purchase_currency')}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="user_id" value="{{@$current_user->id}}" >
                        <div class="row">
                            <div class="col-12 form-group">
                            @if($currencies->count() <= 0)
                                <!-- If the user is linked to no currency we use credit by default -->
                                <h3 class="text-center" for="">Vous aller acheter du crédit</h3>
                                <input type="hidden" name="currency_id" value="1" >
                            @else
                                <label for="currency_id" class="col-sm-12">Selectionnez la monnaie</label>
                                <select name="currency_id" id="currency_id" class="form-control" autocomplete="off">
                                    @forelse($currencies as $key => $currency)
                                        <option value="{{$currency->id}}" {{old("currency_id") == $currency->id ? 'selected':''}}>{{ucfirst($currency->name)}} </option>
                                    @endforeach
                                </select>
                            @endif
                                {!! $errors->first('currency_id', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            <div class="row">
                                <label for="sent_value" class="col-sm-12">Selectionnez le motant que vous désirez acheter *</label>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <select name="price" id="price" class="form-control" autocomplete="off" {{$currencies->count() <= 0?'':'style="display: none"'}}>
                                        <option value=""> Monnaie </option>
                                        {!!$price_options!!}
                                    </select>
                                    {!! $errors->first('price', '<div class="error-message col-12">:message</div>') !!}
                                </div>

                                <div class="col-sm-12 col-md-6">
                                    <button type="submit" name="save" class="btn btn-block btn-success">
                                    <i class="fa fa-credit-card"></i> Confirmer et payer
                                    </button>
                                </div>
                                <div class="col-12 badge badge-warning text-lg text-dark" id="total_price"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script src="{{asset('/dist/ckeditor/ckeditor.js')}}" defer></script>
    <script type="text/javascript" defer>
        $(document).ready(function () {
            update_prices(1);
            $('body').on("change","#currency_id", function(params) {
                const currency_id = $(this).val();
                update_prices(currency_id);
                $("#price").show();
            })
            function update_prices(currency_id)
            {
                const token = $("input[name='_token']").val();
                $.ajax({
                    type: 'post',
                    url: `{{url('/update_prices_list')}}`,
                    data: {'id': currency_id,'_token': token},
                    success: function(res){
                        price.innerHTML = `<option value=""> Monnaie </option>${res}`;
                    }
                });
            }
            $('body').on("change","#price", function(params) {
                const price = $(this).val();
                $("#total_price").text(`Vous payez $${price} CAD`);
            })
        });
    </script>

@endpush