@extends('layouts.back.admin')

@section('title','Mes comptes')

@inject('credit', 'App\Models\Credit')
@section('content')
    <div class="row">
        <div class="col-12 mb-5">
            <a href="{{route('banker.currencies.index')}}" class="btn btn-primary">Enregistrer une nouvelles monnaie</a>
        </div>
    @foreach($currencies as $currency)
        <div class="col-md-6 col-sm-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="{{$currency->icons}}"></i></span>
                <div class="info-box-content">
                    <h3>{{$currency->name}}</h3>
                    <div class="tiny-text mb-3"> {{$currency->description}}</div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valeur Gratuite
                            <span class="badge bg-primary rounded-pill">{{$credit->formatCredit(@$currency->pivot->free_currency ?: 0)}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valeur payante
                            <span class="badge bg-primary rounded-pill">{{$credit->formatCredit(@$currency->pivot->paid_currency ?: 0)}}</span>
                        </li>
                    </ul>
                    <p class="my-4">
                        <a href="{{route('banker.currencies.generate',$currency)}}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-square"></i> Générer
                        </a>
                        <a href="{{route('banker.currencies.transfer',$currency)}}" class="btn btn-light btn-sm">
                            <i class="fas fa-share-square"></i> Transférer
                        </a>
                        <a href="{{route('banker.currencies.edit',$currency)}}" class="btn btn-success btn-sm">
                            <i class="far fa-edit"></i> Éditer
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    @include('layouts.back.alerts.delete-confirmation')

@stop
