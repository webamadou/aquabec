<div class="col-12">
    <form action="{{route('user.updateInfosPerso')}}" method="post" class="row col-12">
        @csrf
        <input type="hidden" name="id" value="{{$user->id}}">
        <div class="offset-sm-1 col-5 form-group row">
            <label for="Région de résidence:" class="col-sm-6 col-md-6">Région de résidence : *</label>
            <select name="region_id" id="region_id" class="form-control">
                <option value=""> --- </option>
                @forelse($region_list as $key => $region)
                    <option value="{{$key}}" {{ (old("region_id") == $key || $user->region_id == $key) ? "selected":"" }}>{{$region}}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="prenom" class="col-sm-6 col-md-6">Prénom : *</label>
            <input tabindex="6" class="form-control" name="prenom" id="prenom" type="text" value="{{old('prenom',$user->prenom)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="city_id" class="col-sm-6 col-md-6">Ville de résidence : *</label>
            <select name="city_id" id="city_id" class="form-control">
                <option value=""> --- </option>
                @forelse($cities_list as $key => $city)
                    <option value="{{$key}}" {{  @$user->city_id == $key ? "selected":"" }}>{{$city}}</option>
                @empty
                @endforelse
            </select>
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="name" class="col-sm-6 col-md-6">Nom : *</label>
            <input class="form-control" id="name" name="name" type="text" value="{{ old('name', $user->name) }}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="postal_code" class="col-sm-6 col-md-6">Code postal : *</label>
            <input class="form-control" name="postal_code" id="postal_code" type="text" value="{{old('postal_code',$user->postal_code)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="gender" class="col-sm-6 col-md-6">Sexe : *</label>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="gender" id="gender_m" autocomplete="off" value="1" {{ intval($user->gender === 1 ) ? 'checked':"" }}>
                <label class="btn btn-outline-primary" for="gender_m"><i class="fa fa-male"></i> Masculin</label>

                <input type="radio" class="btn-check" name="gender" id="gender_f" autocomplete="off" value="0" {{ intval($user->gender === 0 ) ? 'checked':"" }}>
                <label class="btn btn-outline-primary" for="gender_f"><i class="fa fa-female"></i> Feminin</label>
            </div>
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="num_civique" class="col-sm-6 col-md-6">Numéro civique : *</label>
            <input class="form-control" id="num_civique" name="num_civique" type="text" value="{{old('num_civique', $user->num_civique)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="num_tel" class="col-sm-6 col-md-6">Numéro de téléphone : *</label>
            <input  class="form-control phone_number" id="num_tel" name="num_tel" type="text" value="{{old('num_tel',$user->num_tel)}}">
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="age_group" class="col-sm-6 col-md-6">Groupe d'age : *</label>
            <select name="age_group" id="age_group" class="form-control">
                <option value=""> --- </option>
                @foreach($age_group as $key => $age)
                    <option value="{{$key}}" {{ (old("age_group") == $key || $user->age_group == $key) ? "selected":"" }}>{{$age}}</option>
                @endforeach
            </select>
        </div>
        <div class="offset-sm-1 col-5 form-group row">
            <label for="mobile_phone" class="col-sm-6 col-md-6">Cellulaire : *</label>
            <input  class="form-control phone_number" id="mobile_phone" name="mobile_phone" type="text" value="{{old('mobile_phone', $user->mobile_phone)}}">
        </div>
        <div class="col-4 offset-8 mb-4">
            <button class="btn btn-block btn-primary" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
        </div>
    </form>
</div>

