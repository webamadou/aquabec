<div class="row">
   <!--  <form action="{ {route('user.updateInfosPerso')}}" method="post" class="row col-12"> -->
        @csrf
        <div class="offset-sm-1 col-5 form-group row">
            <label for="prenom" class="col-sm-12 col-md-12">Nom d'utilisateur :*</label>
            <input class="form-control" name="username" id="username" type="text" value="{{old('username',$user->username)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="prenom" class="col-sm-12 col-md-12">Prénom :</label>
            <input class="form-control" name="prenom" id="prenom" type="text" value="{{old('prenom',$user->prenom)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="name" class="col-sm-12 col-md-12">Nom :*</label>
            <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="email" class="col-sm-12 col-md-12">Adresse e-mail :* <small>L'utilisateur recevra un message à cette adresse avec tous les détails d'authentification</small></label>
            <input class="form-control" id="email" name="email" type="text" value="{{ old('email', $user->email) }}">
        </div>
        <div class="offset-sm-1 col-11 text-center"> --- </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="gender" class="col-sm-12 col-md-12">Sexe :</label>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="gender" id="gender_m" autocomplete="off" value="1" {{ intval($user->gender === 1 ) ? 'checked':"" }}>
                <label class="btn btn-outline-primary" for="gender_m"><i class="fa fa-male"></i> Masculin</label>

                <input type="radio" class="btn-check" name="gender" id="gender_f" autocomplete="off" value="0" {{ intval($user->gender === 0 ) ? 'checked':"" }}>
                <label class="btn btn-outline-primary" for="gender_f"><i class="fa fa-female"></i> Feminin</label>
            </div>
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="age_group" class="col-sm-12 col-md-12">Groupe d'age :</label>
            <select name="age_group" id="age_group" class="form-control">
                <option value=""> --- </option>
                @foreach($age_group as $key => $age)
                    <option value="{{$key}}" {{ (old("age_group") == $key || $user->age_group == $key) ? "selected":"" }}>{{$age}}</option>
                @endforeach
            </select>
        </div>
        <div class="offset-sm-1 col-11 text-center"> --- </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="Région de résidence:" class="col-sm-12 col-md-12">Région de résidence :</label>
            <select name="region_id" id="region_id" class="form-control">
                <option value=""> --- </option>
                @forelse($region_list as $key => $region)
                    <option value="{{$key}}" {{ ($user->region_id == $key) ? "selected":"" }}>{{$region}}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="city_id" class="col-sm-12 col-md-12">Ville de résidence :</label>
            <select name="city_id" id="city_id" class="form-control">
                <option value=""> --- </option>
                @forelse($cities_list as $key => $city)
                    <option value="{{$key}}" {{  @$user->city_id == $key ? "selected":"" }}>{{$city}}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="postal_code" class="col-sm-12 col-md-12">Code postal :</label>
            <input  class="form-control" name="postal_code" id="postal_code" type="text" value="{{old('postal_code',$user->postal_code)}}">
        </div>
        <div class="offset-sm-1 col-11 text-center"> --- </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="street" class="col-sm-12 col-md-12">Nom de la rue :</label>
            <input  class="form-control" name="street" id="street" type="text" value="{{old('street',$user->street)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="num_civique" class="col-sm-12 col-md-12">Numéro civique (numéro de porte) :</label>
            <input class="form-control" id="num_civique" name="num_civique" type="text" value="{{old('num_civique', $user->num_civique)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
             <label for="num_tel" class="col-sm-12 col-md-12">Numéro de téléphone :</label>
            <input class="form-control phone_number" id="num_tel" name="num_tel" type="text" value="{{old('num_tel',$user->num_tel)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="mobile_phone" class="col-sm-12 col-md-12">Cellulaire :</label>
            <input class="form-control phone_number" id="mobile_phone" name="mobile_phone" type="text" value="{{old('mobile_phone', $user->mobile_phone)}}">
        </div>
        <div class="offset-sm-7 col-5 form-group row mt-4">
           <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
        </div>
    <!-- </form> -->
</div>

