@extends('layouts.back.admin')

@section('title','Tableau de bord')

@section('content')

@inject('credit', 'App\Models\Credit')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-user-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Utilisateurs</span>
                    <span class="info-box-number">{{ $users->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="far fa-address-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Organisations</span>
                    <span class="info-box-number">{{ $organisations->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Evènements</span>
                    <span class="info-box-number">{{ $events->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-award"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Annonces</span>
                    <span class="info-box-number">{{ $announcements->count() }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <h3 class="col-12">Réserve de monnaies</h3>
        @foreach($current_user->currencies as $currency)
        <div class="col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="{{$currency->icons}}"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Réserve {{strtolower($currency->name)}} gratuit</span>
                    <span class="info-box-number">{{ $credit->formatCredit($currency->pivot->free_currency) }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="{{$currency->icons}}"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Réserve {{strtolower($currency->name)}} payant</span>
                    <span class="info-box-number">{{ $credit->formatCredit($currency->pivot->paid_currency) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection
