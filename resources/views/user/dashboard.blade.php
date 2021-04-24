@extends('layouts.front.app')

@section('title','Tableau de bord')

@section('content')

    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mes événements</span>
                    <span class="info-box-number">{{$events}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-award"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mes annonces</span>
                    <span class="info-box-number">{{$announcements}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="far fa-credit-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Mon portefeuille</span>
                    <span class="info-box-number">0 crédit(s)</span>
                </div>
            </div>
        </div>
    </div>

@endsection
