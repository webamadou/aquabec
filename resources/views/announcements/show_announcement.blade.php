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
                        <div class="announcement-img-wrapper"><img src="{{ route('announcement.image',$announcement->images) }}" alt="{{$announcement->title}}"></div>
                        <div class="announcement-meta-wrapper">
                            <div class="row justify-content-between announcement-metas">
                                <div class="col-6"><strong>Une annonce de :</strong></div><div class="col-6 meta-value"><span> {{$announcement->owned->prenom}} {{$announcement->owned->name}} </span></div>
                                <div class="col-6"><strong>Catégorie :</strong></div><div class="col-6 meta-value"><span>{{$announcement->category->name}}</span></div>
                                <div class="col-6"><strong>Postée le :</strong></div><div class="col-6 meta-value"><span> {{$announcement->published_at}} </span></div>
                            </div>
                            <hr>
                            <i class="fa fa-map-marked-alt"></i><br> {{@$announcement->city->name}} <br>  {{@$announcement->region->name}}
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 announcement-container">
                        <h1 class="announcement-title">{{$announcement->title}}</h1>
                        <div class="announcement-description pt-5 pl-4">{!! $announcement->description !!}</div>
                        <div class="announcement-dates">{{$announcement->dates}}</div>
                        <div class="announcement-stats">
                            <ul>
                                <li><i class="fa fa-eye"></i>  {{$announcement->views}} vues</li>
                                <li><i class="fa fa-mouse-pointer"></i> {{$announcement->clicks}} cliques</li>
                            </ul>
                        </div>
                        <div class="d-flex  announcement-footer">
                        <!-- struggling to set a policy. Will do it latter -->
                        @if($current_user->id === $announcement->owner || $current_user->id === $announcement->posted_by)
                            <div class="mx-2"><a href="{{route('user.edit_announcement',$announcement->slug)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Editer </a></div>
                            <div class="mx-2">
                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-delete" data-whatever="{{route('user.delete_announcement',$announcement->slug)}}"><i class="fa fa-user-times"></i> Supprimer</a>
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