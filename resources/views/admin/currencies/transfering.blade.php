@extends('layouts.back.admin')

@section('title','Transfert de monnaies')
@section('page_title','Transfert de monnaies')

@inject('credit', 'App\Models\Credit')
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Transférer de la monnaie</h2>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="{{@$currency->icons}}"></i></span>
                    <div class="info-box-content">
                        <h3>{{$currency->name}}</h3>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Valeur Gratuite
                                <span class="badge bg-primary rounded-pill">{{ $credit->formatCredit(@$currency->pivot->free_currency ?: 0) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Valeur payante
                                <span class="badge bg-primary rounded-pill">{{ $credit->formatCredit(@$currency->pivot->paid_currency ?: 0)}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('banker.currencies.transfering')}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="send_by" value="{{@$user->id}}" >
                        <input type="hidden" name="currency_id" value="{{@$currency->id}}" >
                        <div class="row">
                            @php $_POST @endphp
                            <div class="col-12 form-group">
                                <label for="send_to" class="col-sm-12">Entrez le numéro ou le nom d'utilisateur du destinataire. *</label>
                                <div class="col-sm-12">
                                    <input name="autocomplete_user" id="annonceur_filter" class="form-control select-members" placeholder="Destinataire">
                                    <input name="send_to" id="user_id" type="hidden">
                                    <ul id="autocompletes" style="display: none;"></ul> 
                                </div>
                                <!-- <select name="send_to" id="" class="form-control">
                                    <option value=""></option>
                                    @forelse($users as $user)
                                        <option value="{{$user->id}}" {{old('send_to') == $user->id ? 'selected':''}}>
                                        <strong>{{$user->username}} {{$user->id}} </strong>
                                        </option>
                                    @endforeach
                                </select> -->
                                {!! $errors->first('send_to', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            @role('banquier|super-admin') 
                                <div class="col-12 row">
                                    <div class="col-6 row">
                                        <label class="label">
                                            <input class="col-sm-2 label__checkbox" value="0" id="credit_type_free" name="credit_type" type="radio">
                                            <span class="label__text">
                                                <span class="label__check">
                                                    <i class="fa fa-dot-circle icon"></i>
                                                </span>
                                            </span>
                                        </label>
                                        <label for="credit_type_free" style="font-weight: normal;" class="">Type gratuit</label>
                                    </div>
                                    <div class="col-6 row">
                                        <label class="label">
                                            <input class="col-sm-2 label__checkbox" value="1" id="credit_type_paid" name="credit_type" type="radio">
                                            <span class="label__text">
                                                <span class="label__check">
                                                    <i class="fa fa-dot-circle icon"></i>
                                                </span>
                                            </span>
                                        </label>
                                        <label for="credit_type_paid" style="font-weight: normal;" class="">Type payant</label>
                                    </div>
                                </div>
                            @endrole
                            <div class="col-12 form-group">
                                <label for="sent_value" class="col-sm-12">Entrez la valeur à transférer *</label>
                                <input type="number" name="sent_value" id="sent_value" min="1" class="form-control" value="{{@$_POST['sent_value']}}" >
                                </select>
                                {!! $errors->first('sent_value', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            <div class="col-12 form-group">
                                <label for="notes" class="col-sm-12">Ajouter une note (facultatif)</label>
                                <textarea name="notes" id="notes" cols="30" rows="5" placeholder="Ajouter une note" class="ckeditor form-control">{{old("notes")}}</textarea>
                                </select>
                                {!! $errors->first('notes', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            <div class="col justify-content-end row justify-content-end m-2">
                                <button type="submit" name="save" class="btn btn-sm btn-block btn-primary">
                                <i class="fa fa-save"></i> Transférer
                                </button>
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


@endpush
