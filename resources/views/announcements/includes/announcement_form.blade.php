<div class="offset-sm-0 col-12 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Titre de l'annonce classée : *</label>
    <input type="text" name="title" id="title" value="{{old('title',@$announcement->title)}}" class="form-control">
    {!! $errors->first('title', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-12 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Description de l'annonce : </label>
    <div><textarea name="description" id="description" class="ckeditor form-control">{{old('description',@$announcement->description)}}</textarea></div>
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="images" class="col-sm-12 col-md-12">images de l'annonce : </label>
    <input type="file" name="images" id="images" class="form-control">
    @error('image')
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <img src="{{ route('announcement.image',@$announcement->images) }}" alt="{{@$announcement->title}}" style="width:50%; height: auto">
</div>
<div class="offset-sm-0 col-sm-12 col-md-12 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Categorie de l'annonce classée :* </label>
    <select name="category_id" id="category_id" class="form-control">
        <option value=""> --- </option>
        @foreach($categories as $category)
            <option value="{{$category->id}}" {{old('category_id',@$announcement->category_id) === $category->id?'selected':''}}> {{$category->name}} </option>
        @endforeach
    </select>
    {!! $errors->first('category_id', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="col-12"><hr/></div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Date de l'annonce : </label>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input name="date" id="datePick" class="form-control" />
    </div>
</div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Region de l'annonce classée : </label>
    <select name="region_id" id="region_id" class="form-control">
        <option value=""> --- </option>
        @forelse($regions as $key => $region)
            <option value="{{$key}}" {{ @$announcement->region_id == $key ? "selected":"" }}>{{$region}}</option>
        @empty
        @endforelse
    </select>
</div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Ville de l'annonce classée : </label>
    <select name="city_id" id="city_id" class="form-control">
        <option value=""> --- </option>
        @forelse($cities as $key => $city)
            <option value="{{$key}}" {{  @$announcement->city_id == $key ? "selected":"" }}>{{$city}}</option>
        @empty
        @endforelse
    </select>
</div>
<div class="col-12"><hr></div>
<div class="offset-sm-8 col-sm-12 col-md-4 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Statut de lannonce : * </label>
    <select name="publication_status" id="publication_status" class="form-control">
        <option value=""> --- </option>
        @forelse($status as $key => $statu)
            <option value="{{$key}}" {{  @$announcement->publication_status === $key ? "selected":"" }}>{{$statu}}</option>
        @empty
        @endforelse
    </select>
    {!! $errors->first('publication_status', '<div class="error-message col-12">:message</div>') !!}
</div>