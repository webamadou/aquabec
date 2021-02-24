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
                                <select name="currency_id" id="" class="form-control">
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
                                    <select name="amount" id="amount" class="form-control">
                                        <option value=""> Monnaie </option>
                                        @for($i = 1 ; $i<=20; $i++)
                                            <option value="{{$i}}"> {{ $i * 500 }} à ${{ $i }} CAD</option>
                                        @endfor
                                    </select>
                                    {!! $errors->first('amount', '<div class="error-message col-12">:message</div>') !!}
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
            /* $('.ckeditor').ckeditor(); */
            $('body').on("change","#amount", function(params) {
                const amount = $(this).val();
                $("#total_price").text(`Vous payez $${amount} CAD`);
            })
        });
    </script>

@endpush