<div class="offset-sm-0 col-12 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Titre de l'événement : *</label>
    <input type="text" name="title" id="title" value="{{old('title',@$event->title)}}" class="form-control">
    {!! $errors->first('title', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="datePick" class="col-sm-12 col-md-12">Dates de l'annonce : * <br><small>Vous pouvez sélectionner plusieurs dates</small> </label>
    <input name="dates" id="datePick" class="form-control" value="{{old('dates',@$event->dates)}}"/>
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="timePick" class="col-sm-12 col-md-12">Heure de l'annonce : * <br><small>Précisez l'heure de l'activité</small> </label>
    <input data-clocklet="format: H:mm" name="event_time" id="timePick" class="form-control" value="{{old('event_time',@$event->event_time)}}"/>
</div>
<div class="col-12"><hr/></div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="region_id" class="col-sm-12 col-md-12">Region de l'événement : *</label>
    <select name="region_id" id="region_id" class="form-control">
        <option value=""> --- </option>
        @forelse($regions as $key => $region)
            <option value="{{$key}}" {{ (old('region_id',@$event->region_id)  == $key) ? "selected":"" }}>{{$region}}</option>
        @empty
        @endforelse
    </select>
    {!! $errors->first('region_id', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="city_id" class="col-sm-12 col-md-12">Ville de l'événement : </label>
    <select name="city_id" id="city_id" class="form-control">
        <option value=""> --- </option>
        @forelse($cities as $key => $city)
            <option value="{{$key}}" {{  @$event->city_id == $key ? "selected":"" }}>{{$city}}</option>
        @empty
        @endforelse
    </select>
</div>
<div class="col-12"><hr></div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="postal_code" class="col-sm-12 col-md-12">Code postal : </label>
    <input name="postal_code" id="postal_code" class="form-control" value="{{old('postal_code',@$event->postal_code)}}" />
</div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="email" class="col-sm-12 col-md-12">Email : </label>
    <input type="email" name="email" id="email" class="form-control" value="{{old('email',@$event->email)}}" />
</div>
<div class="offset-sm-0 col-sm-12 col-md-4 form-group row">
    <label for="telephone" class="col-sm-12 col-md-12">Téléphone : </label>
    <input name="telephone" id="telephone" class="form-control phone_number" value="{{old('telephone',@$event->telephone)}}" />
</div>
<div class="offset-sm-0 col-sm-12 form-group row">
    <label for="organiation_id" class="col-sm-12 col-md-12">Organisations : </label>
    <select name="organisation_id" id="organisation_id" class="form-control">
    <option value=""> --- </option>
    @foreach($organisations as $key => $organisation)
        <option value="{{$key}}" {{old('organisation_id',@$event->organisation_id) === $key ? 'selected':""}}>{{$organisation}}</option>
    @endforeach
    </select>
</div>
<div class="col-12"><hr/></div>
<div class="offset-sm-0 col-12 form-group row">
    <label for="description" class="col-sm-12 col-md-12">Description de l'événement (Le poumon) : </label>
    <div class="col-sm-12 col-md-12">
        <textarea name="description" id="description" class="ckeditor form-control">{{old('description',@$event->description)}}</textarea>
    </div>
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="images" class="col-sm-12 col-md-12">images de l'événement : </label>
    <input type="file" name="images" id="images" class="form-control">
    @error('image') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <img src="{{ route('show_image',@$event->images) }}" alt="{{@$event->title}}" style="width:50%; height: auto">
</div>
<div class="col-12"><hr/></div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="category_id" class="col-sm-12 col-md-12">Categorie de l'événement : </label>
    <select name="category_id" id="category_id" class="form-control">
        <option value=""> --- </option>
        @foreach($categories as $category)
            <option value="{{$category->id}}" {{old('category_id',@$event->category_id) === $category->id?'selected':''}}> {{$category->name}} </option>
        @endforeach
    </select>
    {!! $errors->first('category_id', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="publication_status" class="col-sm-12 col-md-12">Statut de lannonce : * </label>
    <select name="publication_status" id="publication_status" class="form-control">
        <option value=""> --- </option>
        @forelse($status as $key => $statu)
            <option value="{{$key}}" {{  @$event->publication_status === $key ? "selected":"" }}>{{$statu}}</option>
        @empty
        @endforelse
    </select>
    {!! $errors->first('publication_status', '<div class="error-message col-12">:message</div>') !!}
</div>