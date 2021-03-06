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
                        <div class="announcement-img-wrapper"><img src="{{ route('show.image',@$event->images) }}" alt="{{@$event->title}}"></div>
                        <div class="announcement-meta-wrapper">
                            <div class="row justify-content-between announcement-metas">
                                <div class="col-6"><strong>Un évènement de :</strong></div><div class="col-6 meta-value"><span> {{@$event->owned->prenom}} {{@$event->owned->name}} </span></div>
                                <div class="col-6"><strong>Catégorie :</strong></div><div class="col-6 meta-value"><span>{{@$event->category->name}}</span></div>
                                <div class="col-6"><strong>Postée le :</strong></div><div class="col-6 meta-value"><span> {{@$event->published_at}} </span></div>
                            </div>
                            <hr>
                            <i class="fa fa-map-marked-alt"></i><br> {{@@$event->city->name}} <br>  {{@@$event->region->name}}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 announcement-container">
                        <h1 class="announcement-title">{{@$event->title}}</h1>
                        <div class="announcement-description pt-5 pl-4">{!! @$event->description !!}</div>
                        <div class="announcement-dates">
                            @foreach(explode(',',@$event->dates) as $key => $date )
                                <span class="badge badge-primary list-event-dates"><i class="fa fa-calendar"></i> {{$date}} </span>
                            @endforeach
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
                                <a href="{{route('user.edit_event',@$event->slug)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Editer </a>
                            </div>
                            <div class="mx-2">
                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete" data-whatever="{{route('user.delete_event',@$event->slug)}}"><i class="fa fa-user-times"></i> Supprimer</a>
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