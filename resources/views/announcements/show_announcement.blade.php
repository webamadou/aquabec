@php use Carbon\Carbon @endphp
@extends('layouts.front.app')
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
                            <div class="announcement-img-wrapper mb-3"><img src="{{ route('show.image',@$announcement->images) }}" alt="{{@$announcement->title}}"></div>
                            <div class="row justify-content-between announcement-metas">
                                <div class="col-6"><strong>Une annonce de :</strong></div><div class="col-6 meta-value"><span> {{@$announcement->owned->prenom}} {{@$announcement->owned->name}} </span></div>
                                <div class="col-6"><strong>Catégorie :</strong></div><div class="col-6 meta-value"><span>{{@$announcement->category->name}}</span></div>
                                <div class="col-6"> 
                                    @if(intval(@$announcement->publication_status) === 1)
                                        <strong>Posté le :</strong></div><div class="col-6 meta-value"><span> {{date('d/m/Y', strtotime(@$announcement->published_at))}} </span>
                                    @else
                                        @if(intval(@$announcement->publication_status) === 0)
                                            <span class="badge badge-warning">Enregistrée en brouillon</span>
                                        @elseif(intval(@$announcement->publication_status) === 2)
                                            <span class="badge badge-primary"><i class="fa fa-user-lock"></i>Enregistrée en Privée</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <i class="fa fa-map-marked-alt"></i><br> {{@@$announcement->city->name}} <br>  {{@@$announcement->region->name}}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 announcement-container">
                        <h1 class="announcement-title">{{@$announcement->title}}</h1>
                        <div class="announcement-description pt-5 pl-4">{!! @$announcement->description !!}</div>
                        <div class="announcement-stats">
                            <ul>
                                <li><i class="fa fa-eye"></i>  {{@$announcement->views}} vues</li>
                                <li><i class="fa fa-mouse-pointer"></i> {{@$announcement->clicks}} cliques</li>
                            </ul>
                        </div>
                        <div class="d-flex  announcement-footer">
                        <!-- struggling to set a policy. Will do it latter -->
                        @if( intval($current_user->id) === intval(@$announcement->owner) || intval($current_user->id) === intval(@$announcement->posted_by))
                            <div class="mx-2"><a href="{{route('user.edit_announcement',@$announcement->slug)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Editer </a></div>
                            <div class="mx-2">
                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete" data-whatever="{{route('user.delete_announcement',@$announcement->slug)}}"><i class="fa fa-user-times"></i> Supprimer</a>
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