@extends('layouts.back.admin')

@section('title','Mes comptes')

@section('content')
    <div class="row">
    @foreach($currencies as $currency)
        <div class="col-md-6 col-sm-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="{{$currency->icons}}"></i></span>
                <div class="info-box-content">
                    <h3>{{$currency->name}}</h3>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valeur Gratuite
                            <span class="badge bg-primary rounded-pill">{{$currency->pivot->free_currency}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Valeur payante
                            <span class="badge bg-primary rounded-pill">{{$currency->pivot->paid_currency}}</span>
                        </li>
                    </ul>
                    <p class="my-4">
                        <a href="{{route('banker.currencies.generate',$currency)}}" class="btn btn-primary">Générer</a>
                        <a href="{{route('banker.currencies.edit',$currency)}}" class="btn btn-success">Éditer</a>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    @include('layouts.back.alerts.delete-confirmation')

@stop
