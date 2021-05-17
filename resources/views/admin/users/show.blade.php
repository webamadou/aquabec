@extends('layouts.back.admin')

@section('title','Liste des monnaies')
@section('page_title',"Profil de ".@$user->username)

@section('content')
    <section class="ftco-about ftco-section ftco-no-pt ftco-no-pb" id="about-section">
        <div class="container">
            <div class="col-sm-12"><a class="btn btn-primary mb-3" href="{{route('admin.users.index')}}"><i class="fa fa-angle-double-left"></i> Retourner vers la liste</a> </div>
            <div class="row d-flex no-gutters">
                <div class="col-md-3 col-lg-3 row">
                    <div class="col-12">
                        <div class="overlay"></div>
                        @if($user->gender != null)
                        <img class="img rounded-circle w-100" src="{{asset('dist/img/avatar'.$user->gender.'.png')}}">
                        @else
                        <img class="img rounded-circle w-100" src="{{asset('dist/img/avatardefault.jpg')}}">
                        @endif
                    </div>
                    <div class="col-12">
                        <h3>Fonctions :</h3>
                        <ul class="row m-0 p-0 justify-content-start">
                        @foreach($user->roles as $role)
                            <li class="badge badge-primary m-1"><strong>{{$role->name}}</strong></li>
                        @endforeach
                        </ul>
                        <hr size="90%" class="mx-auto">
                        <small>Compte crée {{$user->created_at}}</small>
                    </div>
                </div>
                <div class="col-md-9 col-lg-9 pl-md-4 pl-lg-5 py-5">
                    <div class="py-md-1">
                        <div class="row justify-content-start pb-3">
                            <div class="col-md-12 heading-section ftco-animate fadeInUp ftco-animated">
                                <strong class="subheading">{{$user->username}}</strong><br>
                                <h2 class="mb-4" style="font-size: 34px; text-transform: capitalize;">{{$user->prenom}} {{$user->name}}</h2>
                                <span class="subheading">N° {{$user->id}}</span>
                                <p class="p-0 m-0 text-blue">{{$user->email}}</p>
                                <ul class="about-info d-flex px-0">
                                    <li class="d-flex mr-3">
                                        <span>Sexe :&nbsp; </span> <strong>{!! $user->gender == 1 ? " <i class='fa fa-mars'></i> masculin":" <i class='fa fa-venus'></i> feminin"!!}</strong>
                                    </li>
                                    <li class="d-flex mx-3"><span>Groupe d'âge : </span> <strong>{{str_replace('_',' à ',$user->age_group)}}</strong></li>
                                </ul>
                                <hr size="60%" class="mx-auto">
                                <ul class="about-info mt-4 px-md-0 px-2">
                                    <li class="d-flex"><strong>Numéro de téléphone : &nbsp; </strong> <span>{{@$user->telephone ?: " Non précisé"}}</span></li>
                                    <li class="d-flex"><strong>Cellulaire : &nbsp; &nbsp;</strong> <span>{{@$user->mobile ?: " Non précisé"}}</span></li>
                                    <hr size="60%" class="mx-auto">
                                    <li class="d-flex"><strong>Région de résidence : &nbsp; </strong> <span>{{@$user->region->name?: ' Non précisé'}}</span></li>
                                    <li class="d-flex"><strong>Ville de résidence : &nbsp; </strong> <span>{{@$user->city->name ?: " Non précisé"}}</span></li>
                                    <li class="d-flex"><strong>Rue : &nbsp; </strong> <span>{{@$user->street ?: " Non précisé"}}</span></li>
                                    <li class="d-flex"><strong>Numéro civique : &nbsp; </strong> <span>{{@$user->num_civique ?: " Non précisé"}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pr-lg-0 py-1 row justify-content-end">
                @can('update', $user)
                    <a class="btn btn-primary btn-sm" href="{{route('admin.users.edit',$user)}}"><i class="fa fa-user-edit"></i> Modifier</a>
                @endcan
                </div>
            </div>
        </div>
    </section>

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script>
        $(function() {
        });
    </script>

@endpush