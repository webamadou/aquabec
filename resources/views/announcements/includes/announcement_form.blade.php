<div class="offset-sm-0 col-12 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Titre de l'annonce classée : *</label>
    <input type="text" name="title" id="title" value="{{old('title',@$announcement->title)}}" class="form-control">
    {!! $errors->first('title', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-12 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Description de l'annonce ( le poumon ) : </label>
    <div><textarea name="description" id="description" class="ckeditor form-control">{{old('description',@$announcement->description)}}</textarea></div>
</div>

<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="images" class="col-sm-12 col-md-12">Image de l'annonce : </label>
    <input type="file" name="images" id="images" class="form-control">
    <button id="uploadBtn"  type="button" class="browse form-control btn btn-primary">Choisir une image</button>
    @error('image')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <img id="preview" src="{{ route('show_image',@$announcement->images) }}" alt="{{@$announcement->title}}" style="width:50%; height: auto">
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="images" class="col-sm-12 col-md-12">Type de prix : {{@$announcement->price_type}}</label>
    <select name="price_type" id="price_type" class="form-control">
        <option value=""> Sélectionez le type de prix </option>
        <option value="1" {{intval(old('price_type',@$announcement->price_type)) === 1?"selected":"" }}>Entrez le prix</option>
        <option value="3" {{intval(old('price_type',@$announcement->price_type)) === 3?"selected":"" }}>Gratuit</option>
        <option value="2" {{intval(old('price_type',@$announcement->price_type)) === 2?"selected":"" }}>Échange</option>
    </select>
    {!! $errors->first('price_type', '<div class="error-message col-12">:message</div>') !!}
</div>
<div id="price_field_wrapper" class="offset-sm-0 col-sm-12 col-md-6 form-group row" style="{{intval(old('price_type',@$announcement->price_type)) === 1?'':'display:none'}}">
    <label for="images" class="col-sm-12 col-md-12">Price : </label>
    <input type="number" name="price" id="price" min="0" step="0.01" value="{{old('price',@$announcement->price)}}" class="form-control" placeholder="Entrez le prix de votre annonce Ex : 7.5">
</div>
<div class="col-12"><hr/></div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Categorie de l'annonce classée :* </label>
    <select name="category_id" id="category_id" class="form-control">
        <option value=""> --- </option>
        @foreach($categories as $category)
            <option value="{{$category->id}}" {{old('category_id',@$announcement->category_id) == $category->id?'selected':''}}> {{$category->name}} </option>
        @endforeach
    </select>
    {!! $errors->first('category_id', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Type d'annonceur :* </label>
    <select name="advertiser_type" id="advertiser_type" class="form-control">
        <option value=""> --- </option>
            <option value="1" {{intval(old('advertiser_type',@$announcement->advertiser_type)) === 1?'selected':''}}> Particulier </option>
            <option value="2" {{intval(old('advertiser_type',@$announcement->advertiser_type)) === 2?'selected':''}}> Commerce </option>
    </select>
    {!! $errors->first('advertiser_type', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Region de l'annonce classée : </label>
    <select name="region_id" id="region_id" class="form-control">
        <option value=""> --- </option>
        @forelse($regions as $key => $region)
            <option value="{{$key}}" {{ intval(old('region_id',@$announcement->region_id)) === intval($key) ? "selected":"" }}>{{$region}}</option>
        @empty
        @endforelse
    </select>
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Ville de l'annonce classée : </label>
    <select name="city_id" id="city_id" class="form-control">
        <option value=""> --- </option>
        @forelse($cities as $key => $city)
            <option value="{{$key}}" {{  intval(old('city_id',@$announcement->city_id)) === intval($key) ? "selected":"" }}>{{$city}}</option>
        @empty
        @endforelse
    </select>
</div>
<div class="col-12"><hr></div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="postal_code" class="col-sm-12 col-md-12">Code postal : </label>
    <input name="postal_code" id="postal_code" class="form-control" value="{{old('postal_code',@$announcement->postal_code)}}" />
</div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="email" class="col-sm-12 col-md-12">Email : </label>
    <input type="email" name="email" id="email" class="form-control" value="{{old('email',@$announcement->email)}}" />
</div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="telephone" class="col-sm-12 col-md-12">Téléphone : </label>
    <input name="telephone" id="telephone" class="form-control phone_number" value="{{old('telephone',@$announcement->telephone)}}" />
</div>
<div class="col-12"><hr></div>
<div class="offset-sm-8 col-sm-12 col-md-4 form-group row">
    @if($can_post)
    <label for="title" class="col-sm-12 col-md-12">Statut de lannonce : * </label>
    <select name="publication_status" id="publication_status" class="form-control">
        <option value=""> --- </option>
        @forelse($status as $key => $statu)
            <option value="{{$key}}" {{  old('publication_status',@$announcement->publication_status) == $key ? "selected":"" }}>{{$statu}}</option>
        @empty
        @endforelse
    </select>
    @else
    <input type="hidden" name="publication_status" id="publication_status" value="0">
    @endif
    {!! $errors->first('publication_status', '<div class="error-message col-12">:message</div>') !!}
</div>

<script>
    $(document).ready(function () {
    });
</script>