@extends('layouts.back.admin')

@section('title',"Ajout d'un profil ")
@section('page_title',"Enregistrement d'un profil ")

@section('content')
    <a class="btn btn-primary mb-3" href="{{route('admin.users.index')}}"><i class="fa fa-angle-double-left"></i> Retourner vers la liste</a>
    <div class="col-12 container-fluid bg-white">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('admin.users.store')}}" method="post" class="row col-12">
            @csrf
            <input type="hidden" name="id" value="{{$user->id}}">
            <div class="offset-sm-1 mx-auto col-11 form-group row">
                <label for="godfather" class="col-sm-6 col-md-6">Parain : <br><small>Ce champ est utile pour inscrire un équipier dans une équipe.</small></label>
                <select name="godfather" id="godfather" class="form-control">
                    <option value=""> --- </option>
                    @forelse($vendors as $vendor)
                        <option value="{{$vendor->id}}" {{ (old("godfather") == $vendor->id || $user->godfather == $vendor->id) ? "selected":"" }}>{{$vendor->prenom.' '.$vendor->name}}</option>
                    @empty
                    @endforelse
                </select>
                {!! $errors->first('gofather', '<div class="error-message col-12">:message</div>') !!}
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="prenom" class="col-sm-6 col-md-6">Prénom : </label>
                <input tabindex="6" class="form-control" name="prenom" id="prenom" type="text" value="{{old('prenom',$user->prenom)}}">
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="name" class="col-sm-6 col-md-6">Nom : *</label>
                <input tabindex="6" class="form-control" name="name" id="name" type="text" value="{{old('name',$user->name)}}">
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="email" class="col-sm-6 col-md-6">Adresse Électronique :*</label>
                <input tabindex="6" class="form-control" name="email" id="email" type="text" value="{{old('email',$user->email)}}">
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="username" class="col-sm-6 col-md-6">Nom d'utilisateur :*</label>
                <input tabindex="6" class="form-control" name="username" id="username" type="text" value="{{old('username',$user->username)}}">
            </div>
            <div class="col-12 text-center"> --- </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="age_group" class="col-sm-6 col-md-6">Groupe d'age :</label>
                <select name="age_group" id="age_group" class="form-control">
                    <option value=""> --- </option>
                    @foreach($age_group as $key => $age)
                        <option value="{{$key}}" {{ (old("age_group") == $key || $user->age_group == $key) ? "selected":"" }}>{{$age}}</option>
                    @endforeach
                </select>
            </div>
            <div class="offset-sm-1 col-5 form-group row">
                <label for="gender" class="col-sm-6 col-md-6">Sexe :</label>
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <div class="form-group row justify-content-center bg-light">
                        <label for="gender_m" class="col-sm-6 col-md-6">Masculin</label>
                        <label class="label col-sm-6 col-md-6">
                            <!-- <input class="label__checkbox" id="free_events" name="free_events" type="radio" value="1" { { $role->free_events>=1 ?"checked": "" }}> -->
                            <input type="radio" class="label__checkbox" name="gender" id="gender_m" autocomplete="off" value="1" {{ intval($user->gender === 1 ) ? 'checked':"" }}>
                            <span class="label__text">
                                <span class="label__check">
                                    <i class="fa fa-mars"></i>
                                </span> 
                            </span>
                        </label>
                    </div>
                    <div class="form-group row justify-content-center bg-light">
                        <label for="gender_f" class="col-sm-6 col-md-6">Feminin</label>
                        <label class="label col-sm-6 col-md-6">
                            <input type="radio" class="label__checkbox" name="gender" id="gender_f" autocomplete="off" value="0" {{ intval($user->gender === 0 ) ? 'checked':"" }}>
                            <span class="label__text">
                            <span class="label__check">
                                <i class="fa fa-venus"></i>
                            </span> 
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center"> --- </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="Parrain" class="col-sm-6 col-md-6">Région de résidence :</label>
                <select name="region_id" id="region_id" class="form-control">
                    <option value=""> --- </option>
                    @forelse($region_list as $key => $region)
                        <option value="{{$key}}" {{ (old("region_id") == $key || $user->region_id == $key) ? "selected":"" }}>{{$region}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="city_id" class="col-sm-6 col-md-6">Ville de résidence :</label>
                <select name="city_id" id="city_id" class="form-control">
                    <option value=""> --- </option>
                    @forelse($cities_list as $key => $city)
                        <option value="{{$key}}" {{  @$user->city_id == $key ? "selected":"" }}>{{$city}}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="postal_code" class="col-sm-6 col-md-6">Code postal :</label>
                <input class="form-control" name="postal_code" id="postal_code" type="text" value="{{old('postal_code',$user->postal_code)}}">
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="num_civique" class="col-sm-6 col-md-6">Numéro civique :</label>
                <input class="form-control" id="num_civique" name="num_civique" type="text" value="{{old('num_civique', $user->num_civique)}}">
            </div>
            <div class="col-12 mx-auto"><hr></div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="num_tel" class="col-sm-6 col-md-6">Numéro de téléphone :</label>
                <input  class="form-control phone_number" id="num_tel" name="num_tel" type="text" value="{{old('num_tel',$user->num_tel)}}">
            </div>
            <div class="offset-sm-1 mx-auto col-5 form-group row">
                <label for="mobile_phone" class="col-sm-6 col-md-6">Cellulaire :</label>
                <input  class="form-control phone_number" id="mobile_phone" name="mobile_phone" type="text" value="{{old('mobile_phone', $user->mobile_phone)}}">
            </div>
            <div class="col-12 text-center"> --- </div>
            <div class="offset-sm-1 mx-auto col-11 form-group row">
                <label for="role" class="col-sm-12 col-md-12">Fonction : <br><small>Modifier la fonction du profil</small></label>
                <div class="row bg-gray-light pt-2 justify-content-center">
                @forelse($roles as $role)
                    <div class="col-3 form-group row justify-content-center bg-light mx-1">
                        <label for="role_{{$role}}" class="col-sm-6 col-md-6">{{ucfirst(str_replace('-', ' ', $role))}}</label>
                        <label class="label col-sm-6 col-md-6">
                            <input class="label__checkbox" id="role_{{$role}}" name="role_{{$role}}" type="checkbox" value="1" {{ $role == $user->hasRole($role) ?"checked": "" }}>
                            <span class="label__text">
                            <span class="label__check">
                                <i class="fa fa-check icon"></i>
                            </span>
                            </span>
                        </label>
                    </div>
                @empty
                @endforelse
                </div>
            </div><!-- 
            <div class="mx-auto my-3 bg-gray-light col-12 row">
                <div class="offset-sm-1 mx-auto col-5 form-group row">
                    <label for="password" class="col-sm-12 col-md-12">Mot de passe : </label>
                    <input id="password" type="password" name="password" class="form-control uk-input"  placeholder="Votre mot de passe">
                </div>
                <div class="offset-sm-1 mx-auto col-5 form-group row">
                    <label for="password-confirm" class="col-sm-12 col-md-12">Confirmer le mot de passe : </label>
                    <input id="password-confirm" type="password" name="password_confirmation" class="form-control uk-input" placeholder="Confirmation du mot de passe">
                </div>
            </div> -->
            <div class="col-4 offset-8 mb-4">
                <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
            </div>
        </form>
    </div>

    @include('layouts.back.alerts.delete-confirmation')

@stop

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

