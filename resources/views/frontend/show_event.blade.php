@php use Carbon\Carbon @endphp
@extends('layouts.front.master')
@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="card">
                <div class="card-body row overflow-hidden">
                    <div class="col-sm-12 col-md-3 announcement-side-bar">
                        <div class="announcement-meta-wrapper">
                            <div class="announcement-img-wrapper mb-3">
                                <img src="{{ route('show_image',@$event->images) }}" alt="{{@$event->title}}">
                            </div>
                            <div class="row justify-content-between announcement-metas">
                                <div class="col-6"><strong>Catégorie :</strong></div><div class="col-6 meta-value"><span>{{@$event->category->name}}</span></div>
                                <div class="col-6"> 
                                    @if(intval($event->publication_status) === 1)
                                        <strong>Posté le :</strong></div><div class="col-6 meta-value"><span> {{date('d/m/Y', strtotime($event->published_at))}} </span>
                                    @else
                                        @if(intval($event->publication_status) === 0)
                                            <span class="badge badge-warning">Enregistrée en brouillon</span>
                                        @elseif(intval($event->publication_status) === 2)
                                            <span class="badge badge-primary"><i class="fa fa-user-lock"></i>Enregistrée en Privée</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-6"><strong>N° de l'annonce :</strong></div><div class="col-6 meta-value px-4"><span>{{sprintf("%05d",@$event->id)}}</span></div>
                                <div class="col-12 text-center"> <hr> </div>
                                <div class="col-12"> <strong>Publié par :</strong> </div>
                                <ul class="list-group list-group-flush px-4 list-metas">
                                    <li class="list-group-item"><i class="fa fa-user"></i> {{@$event->owned->username}} </li>
                                    @if(trim(@$event->owned->mainRole()->name) !== "")
                                        <li class="list-group-item"> <strong><i class="fa fa-user-lock"></i> Fonction</strong> {{@$event->owned->mainRole()->name}} </li>
                                    @endif
                                    @if(trim(@$event->advertiser_type) !== "")
                                        <li class="list-group-item"> <strong><i class="fa fa-user-lock"></i> </strong> {{@$event->advertiser_type}} </li>
                                    @endif
                                    <!-- -- -->
                                    @if(trim(@$event->telephone) !== "")<li class="list-group-item"><i class="fa fa-phone-alt"></i> {{@$event->telephone}}</li>@endif
                                    @if(trim(@$event->website) !== "")<li class="list-group-item"><i class="fa fa-laptop-house"></i> <a href="{{@$event->website}}" target="_blank">{{@$event->website}}</a> </li>@endif
                                    @if(trim(@$event->postal_code) !== "")<li class="list-group-item"><i class="fa fa-map"></i> Code postal : {{@$event->postal_code}}</li>@endif
                                </ul>
                                <div class="col-12 text-center"> <hr> </div>
                                <div class="col-12 bg-white mx-0">
                                    <strong><i class="fa fa-home"></i> Organisation :</strong> 
                                    <span class="text-center px-4 font-bold">{{@$event->organisation->name}} </span>
                                </div>                               
                            </div>
                            <hr>
                            @if(!empty($event->announcement))
                                <hr>
                                <div class="bg-light p-2 mt-5">
                                    <strong><i class="fa fa-bullhorm"></i> Vers L'annonce de l'activité :</strong>
                                    <h5><a class="btn-link" href="{{route('page_annonce',@$event->announcement->slug)}}"></a></h5>
                                    <div>
                                        <a href="{{route('page_annonce',@$event->announcement->slug)}}">
                                            <img class="img-fluid" src="{{ route('show_image',@$event->announcement->images) }}" alt="{{@$event->title}}" style="width:6vh">
                                            <span class="small">{{ucfirst($event->announcement->title)}}</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 announcement-container">
                        <h3 class="announcement-title">{{@$event->title}}</h3>
                        <div class="announcement-description pt-5 pl-4">{!! @$event->description !!}</div>
                        <div>
                            <h3>Lieu <i class="fa fa-map-marked-alt"></i></h3>
                            {{@$event->city->name}} <br>  {{@$event->region->name}}
                        </div>
                        <div class="row announcement-dates mt-3 bg-gray-light px-3 py-3">
                            <div class="col-sm-12 col-md-3"><span class="small font-bold">Date(s) de l'événement : </span></div>
                            <div class="col-sm-12 col-md-9">
                                @foreach(@$event->event_dates as $date )
                                    <span class="badge badge-primary list-event-dates"><i class="fa fa-calendar"></i> {{ date( "d-m-Y H:i",strtotime($date->event_date) )}} </span>
                                @endforeach
                            </div>
                            <!-- <div class="col-sm-12 col-md-3"><span class="small font-bold">Heure de l'événement : </span></div>
                            <div class="col-sm-12 col-md-9">
                                    <span class="badge badge-warning list-event-dates"><i class="fa fa-clock"></i> {{$event->event_time}} </span>
                            </div> -->
                        </div>
                        <div class="announcement-stats">
                            <ul>
                                <li><i class="fa fa-eye"></i>  {{@$event->views}} vues</li>
                                <li><i class="fa fa-mouse-pointer"></i> {{@$event->clicks}} cliques</li>
                            </ul>
                        </div>
                        <div class="d-flex  announcement-footer">
                        <!-- struggling to set a policy. Will do it latter -->
                        @if(@$current_user->id === @$event->owner || @$current_user->id === @$event->posted_by)
                            <div class="mx-2">
                                <a href="{{route('user.edit_event',@$event->slug)}}" class="btn btn-sm btn-primary py-2"><i class="fa fa-edit"></i> Editer </a>
                            </div>
                            <div class="mx-2">
                                <a href="#" class="btn btn-sm btn-danger py-2" data-toggle="modal" data-target="#modal-delete" data-whatever="{{route('user.delete_event',@$event->slug)}}"><i class="fa fa-user-times"></i> Supprimer</a>
                            </div>
                        @endif
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