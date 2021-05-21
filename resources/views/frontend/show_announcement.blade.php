@php use Carbon\Carbon @endphp
@extends('layouts.front.master')
@section('content')
    <div class="row">
        <div class="my-4 col-12 row">
            <!-- <h2 class="my-0"> - </h2> -->
        </div>
        <div class="col-12 tab-content " id="nav-tabContent">
            <div class="card">
                <div class="card-body row overflow-hidden position-relative" style="overflow: hidden">
                    <div class="col-sm-12 col-md-3 announcement-side-bar">
                        <div class="announcement-meta-wrapper">
                            <div class="announcement-img-wrapper mb-3">
                                <img src="{{ route('show_image',@$announcement->images) }}" alt="{{@$announcement->title}}" class="img-fluid">
                            </div>
                            <div class="row justify-content-between announcement-metas">
                                <div class="col-6"><strong>Une annonce de :</strong></div><div class="col-6 meta-value"><span> {{@$announcement->owned->prenom}} {{@$announcement->owned->name}} </span></div>
                                <div class="col-6"><strong>Catégorie :</strong></div><div class="col-6 meta-value"><span>{{@$announcement->category->name}}</span></div>
                                <div class="col-6">
                                    @if(intval(@$announcement->publication_status) === 1)
                                        <strong>Posté le :</strong></div><div class="col-6 meta-value"><span> {{date('d/m/Y', strtotime(@$announcement->published_at))}} </span>
                                    @else
                                        @if(intval(@$announcement->publication_status) === 0)
                                            <span class="badge badge-">Brouillon</span>
                                        @elseif(intval(@$announcement->publication_status) === 2)
                                            <span class="badge badge-"><i class="fa fa-user-lock"></i> Privée</span>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-12 text-center"> <hr> </div>
                                <div class="col-12"> <strong>Annonceur :</strong> </div>
                                <ul class="row flex-column p-0 mx-1 publication-meta w-100">
                                    <li class="list-group-item"><i class="fa fa-user"></i> {{@$announcement->owned->prenom}} {{@$announcement->owned->name}} </li>
                                    @if(trim(@$announcement->owned->mainRole()->name) !== "")<li class="list-group-item"> <strong><i class="fa fa-user-lock"></i> Fonction</strong> {{@$announcement->owned->mainRole()->name}} </li>@endif
                                    <li class="list-group-item"><i class="fa fa-envelope"></i> {{@$announcement->email}}</li>
                                    @if(trim(@$announcement->telephone) !== "")<li class="list-group-item"><i class="fa fa-phone-alt"></i> {{@$announcement->telephone}}</li>@endif
                                    @if(trim(@$announcement->postal_code) !== "")<li class="list-group-item"><i class="fa fa-mail-bulk"> Code Postal</i> {{@$announcement->postal_code}}</li>@endif
                                    <li class="list-group-item"><i class="fa fa-map-marked-alt"></i><br> {{@$announcement->city->name}} <br>  {{@$announcement->region->name}}</li>
                                    @if(trim(@$announcement->website) !== "")<li class="list-group-item"><i class="fa fa-laptop-house"></i><a href="{{@$announcement->website}}" target="_blank"> {{@$announcement->website}}</a></li>@endif
                                </ul>
                            </div>
                            <hr>
                            <i class="fa fa-map-marked-alt"></i><br> {{@$announcement->city->name}} <br>  {{@$announcement->region->name}}
                            @if(!empty(@$announcement->event))
                                <hr>
                                <div class="bg-light p-2 mt-5">
                                    <strong><i class="fa fa-bullhorm"></i> Vers l'activité de l'annonce :</strong>
                                    <div>
                                        <a href="{{route('page_evenement',@$announcement->event->slug)}}">
                                            <img class="img-fluid rounded float-start" src="{{ route('show_image',@$announcement->event->images) }}" alt="{{@$announcement->event->title}}" style="width: 6vh"> {{ucfirst($announcement->event->title)}}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 announcement-container">
                        <h3 class="announcement-title">{{@$announcement->title}}</h3>
                        <div class="announcement-description pt-5 pl-4">{!! @$announcement->description !!}</div>
                        <div class="announcement-dates mt-3 bg-gray-light px-3 py-3">
                            <strong>Prix : </strong>
                            <h3 class="badge badge-primary list-event-dates">{{$announcement->getPrice()}} </h3>
                        </div>
                        <div class="col-12"><strong>N° de l'annonce :</strong><span>{{sprintf("%05d",@$announcement->id)}}</span></div>
                        <div class="announcement-dates">{{@$announcement->dates}}</div>
                        <div class="announcement-stats">
                            <ul>
                                <li><i class="fa fa-eye"></i>  {{@$announcement->views}} vues</li>
                                <li><i class="fa fa-mouse-pointer"></i> {{@$announcement->clicks}} cliques</li>
                            </ul>
                        </div>
                        <div class="d-flex  announcement-footer">
                            <!-- struggling to set a policy. Will do it latter -->
                            @if(intval(@$current_user->id) === intval(@$announcement->owner) || intval(@$current_user->id) === intval(@$announcement->posted_by))
                                <div class="mx-2"><a href="{{route('user.edit_announcement',@$announcement->slug)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Modifier </a></div>
                                <div class="mx-2">
                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete" data-whatever="{{route('user.delete_announcement',@$announcement->slug)}}"><i class="fa fa-user-times"></i> Supprimer</a>
                                </div>
                            @endif
                        </div>
                        <div class="row justify-content-center">
                            @php
                             $region_name = str_replace(["(saint)","saint"],'',strtolower(@$announcement->region->name));
                            @endphp
                            <!-- <iframe width="100%" height="240" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Abercorn,{{@$announcement->postal_code}}&key=AIzaSyCrPpsyOFrP3BCOGcbyYp8zbU7WRtQSNIk"></iframe>-->
                            <iframe width="100%" height="240" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{@$region_name}},{{@$announcement->postal_code}}&key=AIzaSyC8-GVIaSiFceeP9qmTdHvvVfQXD0pMc0A" allowfullscreen="" loading="lazy"></iframe>
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