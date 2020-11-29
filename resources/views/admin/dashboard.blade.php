@extends('layouts.back.admin')

@section('title','Dashboard')

@section('content')

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="far fa-user-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Utilisateurs</span>
                    <span class="info-box-number">{{ $users->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="far fa-address-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Organisations</span>
                    <span class="info-box-number">{{ $organisations->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-th-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Evènements</span>
                    <span class="info-box-number">{{ $events->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-award"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Annonces</span>
                    <span class="info-box-number">{{ $announcements->count() }}</span>
                </div>
            </div>
        </div>
    </div>

@endsection
