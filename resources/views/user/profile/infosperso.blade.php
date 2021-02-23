@php use Carbon\Carbon;@endphp
@extends('layouts.front.app')

<!-- @ section('title','Informations personelles') -->

@section('content')

    <div class="row">
        <div class="my-4 col-12 row">
            <div class="col-1">
                <img src="{{asset('dist/img/avatar5.png')}}" alt="" class="rounded-circle" width="50">
            </div>
            <div class="col-11"> 
                <h2 class="my-0">{{$user->prenom}} {{$user->name}}</h2>
                <div><span class="my-0">{{$user->email}}</span></div>
                @foreach(@$user->roles as $role)
                    <span class="badge bg-info">{{$role->name}}</span> 
                @endforeach
                <small>Compte crée {{$user->created_at}}</small>
            </div>
        </div>
        <nav class="col-12">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link {{@$default_tab=='account'?'active':''}}" id="nav-account-tab" data-bs-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="true"><i class="fa fa-cogs"></i> Mon Compte</a>
                <!-- <a class="nav-link {{@$default_tab=='events'?'active':''}}" id="nav-events-tab" data-bs-toggle="tab" href="#nav-events" role="tab" aria-controls="nav-events" aria-selected="false"><i class="fa fa-list"></i> Mes Événements</a> -->
                <a class="nav-link {{@$default_tab=='wallet'?'active':''}}" id="nav-wallet-tab" data-bs-toggle="tab" href="#nav-wallet" role="tab" aria-controls="nav-wallet" aria-selected="false"><i class="fa fa-wallet"></i> Mon portefeuille </a>
                <a class="nav-link {{@$default_tab=='transactions'?'active':''}}" id="nav-transactions-tab" data-bs-toggle="tab" href="#nav-transactions" role="tab" aria-controls="nav-transactions" aria-selected="false"><i class="fa fa-list"></i> Mes Transactions</a>
                <a class="nav-link {{@$default_tab=='infos-perso'?'active':''}}" id="nav-infos-perso-tab" data-bs-toggle="tab" href="#nav-infos-perso" role="tab" aria-controls="nav-infos-perso" aria-selected="false"><i class="fa fa-user"></i> Informations Personelles</a>
                <a class="nav-link {{@$default_tab=='security'?'active':''}}" id="nav-security-tab" data-bs-toggle="tab" href="#nav-security" role="tab" aria-controls="nav-security" aria-selected="false"><i class="fa fa-user-lock"></i> Sécurité </a>
            </div>
        </nav>
        <div class="col-12 tab-content" id="nav-tabContent">
            <div class="tab-pane fade {{@$default_tab=='account'?'show active':''}}" id="nav-account" role="tabpanel" aria-labelledby="nav-account-tab">
                @include("user.profile.includes.account_fonctions")
            </div>
            <!-- <div class="tab-pane fade {{@$default_tab=='events'?'show active':''}}" id="nav-events" role="tabpanel" aria-labelledby="nav-events-tab">
                <h1>My events</h1>
            </div> -->
            <div class="tab-pane fade {{@$default_tab=='wallet'?'show active':''}}" id="nav-wallet" role="tabpanel" aria-labelledby="nav-wallet-tab">
                <div class="bg-white">
                    @include('user.profile.includes.my_wallet')
                </div>
            </div>
            <div class="tab-pane fade {{@$default_tab=='transactions'?'show active':''}}" id="nav-transactions" role="tabpanel" aria-labelledby="nav-transactions-tab">
               @include('user.profile.includes.my_transactions')
            </div>
            <div class="tab-pane fade {{@$default_tab=='infos-perso'?'show active':''}}" id="nav-infos-perso" role="tabpanel" aria-labelledby="nav-infos-perso-tab">
                <div class="bg-white">
                    <h2 class="text-center mb-1">Informations Personelles</h2>
                    <div class="text-center text-bold mb-4">*Requis pour postulant uniquement*</div>
                    <hr size="1" width="50%" class="mx-auto">
                    @include('user.profile.includes.infosperso_form')
                </div>
            </div>
            <div class="tab-pane fade {{@$default_tab=='security'?'show active':''}}" id="nav-security" role="tabpanel" aria-labelledby="nav-security-tab">
                <div class="bg-white">
                    <h2 class="text-center mb-1">Modifier mon mot de passe</h2>
                    @include('user.profile.includes.change_pwd')
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

    <script defer>
        $(function() {
            //*** Select the cities of the selected region ***
            const regions = document.getElementById("region_id");
            document.getElementById("region_id").addEventListener('change', function (event) {
                const selected_region = this.value;
                $.ajax({
                    type: 'get',
                    url: `{{url('/select_cities')}}`,
                    data: {'id': selected_region},
                    success: function(res){
                        const entries = Object.entries(res);
                        const cities_field = document.getElementById("city_id");
                        cities_field.innerHTML = `<option value=""> --- </option>`;
                        for(const [key,region] of entries){
                            console.log(key);
                            cities_field.innerHTML += `<option value="${key}">${region}</option>`;
                        }
                    }
                });
            });
        });
    </script>

@endpush