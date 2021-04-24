@php use Carbon\Carbon @endphp
@extends('layouts.back.admin')

@section('content')
    <div class="row">
    <a class="btn btn-primary mb-3" href="{{route('admin.announcements')}}"><i class="fa fa-angle-double-left"></i> Retourner vers la liste</a>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-body row overflow-hidden">
                    <div class="col-sm-12 col-md-3 announcement-side-bar">
                        <div class="announcement-meta-wrapper">
                            <div class="announcement-img-wrapper mb-3">
                                <img src="{{ route('show_image',@$announcement->images) }}" alt="{{@$announcement->title}}">
                            </div>
                            <div class="row justify-content-between announcement-metas">
                                <div class="col-6"><strong>Catégorie :</strong></div><div class="col-6 meta-value"><span>{{@$announcement->category->name}}</span></div>
                                <div class="col-6"> 
                                    @if(intval($announcement->publication_status) === 1)
                                        <strong>Posté le :</strong></div><div class="col-6 meta-value"><span> {{date('d/m/Y', strtotime($announcement->published_at))}} </span>
                                    @else
                                        @if(intval($announcement->publication_status) === 0)
                                            <span class="badge badge-warning">Enregistrée en brouillon</span>
                                        @elseif(intval($announcement->publication_status) === 2)
                                            <span class="badge badge-primary"><i class="fa fa-user-lock"></i>Enregistrée en Privée</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-12 text-center mt-2">  </div>
                                <div class="col-6"><strong>N° de l'annonce :</strong></div><div class="col-6 meta-value px-4"><span>{{sprintf("%05d",@$announcement->id)}}</span></div>
                                <div class="col-12 text-center"> <hr> </div>
                                <div class="col-12"> <strong>Publié par :</strong> </div>
                                <ul class="list-group">
                                    <li class="list-group-item"><i class="fa fa-user"></i> {{@$announcement->owned->prenom}} {{@$announcement->owned->name}} <br><strong><i class="fa fa-caret-right"></i> {{@$announcement->advertiser}}</strong></li>
                                    @if(trim(@$announcement->owned->mainRole()->name) !== "")<li class="list-group-item"> <strong><i class="fa fa-user-lock"></i> Fonction</strong> {{@$announcement->owned->mainRole()->name}} </li>@endif
                                    <li class="list-group-item"><i class="fa fa-envelope"></i> {{@$announcement->email}}</li>
                                    @if(trim(@$announcement->telephone) !== "")<li class="list-group-item"><i class="fa fa-phone-alt"></i> {{@$announcement->telephone}}</li>@endif
                                    @if(trim(@$announcement->postal_code) !== "")<li class="list-group-item"><i class="fa fa-mail-bulk"> Codparticuliere Postal</i> {{@$announcement->postal_code}}</li>@endif
                                    @if(trim(@$announcement->website) !== "")<li class="list-group-item"><i class="fa fa-home"></i> {{@$announcement->website}}</li>@endif
                                </ul>
                            </div>
                            <!-- <hr> -->
                            @if(!empty($announcement->event))
                                <hr>
                                <div class="bg-light p-2 mt-5">
                                    <strong><i class="fa fa-bullhorm"></i> Vers l'activité de l'annonce :</strong>
                                    <h5><a class="btn-link" href="{{route('admin.show_event',@$announcement->event)}}">{{ucfirst($announcement->event->title)}}</a></h5>
                                    <div>
                                        <a href="{{route('admin.show_event',@$announcement->event)}}">
                                            <img class="img-fluid" src="{{ route('show_image',@$announcement->event->images) }}" alt="{{@$event->title}}" style="width:12vh">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 announcement-container">
                        <h1 class="announcement-title">{{@$announcement->title}}</h1>
                        <div class="announcement-description pt-5 pl-4">{!! @$announcement->description !!}</div>
                        <div class="announcement-dates mt-3 bg-gray-light px-3 py-3">
                            <strong>Prix de l'événement : </strong>
                            <h3 class="badge badge-primary list-event-dates"><i class="fa fa-calendar"></i> {{$announcement->getPrice()}} </h3>
                        </div>
                        <div class="announcement-stats">
                            <ul>
                                <li><i class="fa fa-eye"></i>  {{@$announcement->views}} vues</li>
                                <li><i class="fa fa-mouse-pointer"></i> {{@$announcement->clicks}} cliques</li>
                            </ul>
                        </div>
                        <div class="d-flex  announcement-footer">
                            <div class="mx-2"><a href="{{route('admin.edit_announcement',@$announcement)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Modifier </a></div>
                            <div class="mx-2">
                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete" data-whatever="{{route('admin.delete_announcement',@$announcement)}}"><i class="fa fa-user-times"></i> Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.front.alerts.delete-confirmation')
@endsection

@push('scripts')

    <script defer>
        $(function() {
        });
    </script>

@endpush