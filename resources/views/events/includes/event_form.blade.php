<div class="offset-sm-0 col-12 form-group row">
    <label for="title" class="col-sm-12 col-md-12">Titre de l'événement : *</label>
    <input type="text" name="title" id="title" value="{{old('title',@$event->title)}}" class="form-control">
    {!! $errors->first('title', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="datePick" class="col-sm-12 col-md-12">Dates de l'annonce : * <br><small>Vous pouvez sélectionner plusieurs dates</small> </label>
    <!-- <input name="dates" id="datePick" class="form-control" value="{{old('dates',@$event->dates)}}"/>
    <label for="inputPassword3" class="col-sm-12 control-label">Dates</label> -->
    <div class="input-group date">
        <input type="text" class="form-control" id="datetimepicker1" data-validation="required" value="{{old('dates',str_replace('*',' ', @$event->dates) ) }}" />
        <span class="input-group-addon datepicker-incon-wrapper">
            <span class="fa fa-calendar"></span>
        </span>
    </div>
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
<!-- <div class="col-lg-2 col-md-2 col-sm-5 sandbox-container"> -->
    <input type="hidden" id="datefinal" name="dates" value="{{old('dates',@$event->dates)}}">
    <input type="hidden" id="hourselected" class="hourselected" name="hourselected">
    <button class="btn btn-primary hide btn-TimeSelection mt-5" type="button">Choisir les heures</button>
<!-- </div> --
    <label for="timePick" class="col-sm-12 col-md-12">Heure de l'annonce : * <br><small>Précisez l'heure de l'activité</small> </label>
    <input data-clocklet="format: H:mm" name="event_time" id="timePick" class="form-control" value="{{old('event_time',@$event->event_time)}}"/>
    -->
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
        <option value="{{$key}}" {{intval(old('organisation_id',@$event->organisation_id)) === $key ? 'selected':""}}>{{$organisation}}</option>
    @endforeach
    </select>
</div>
<div class="col-12"><hr/></div>
<div class="offset-sm-0 col-12 form-group row">
    <label for="description" class="col-sm-12 col-md-12">Description de l'événement (Le poumon) : </label>
    <div><textarea name="description" id="description" class="ckeditor form-control">{{old('description',@$event->description)}}</textarea></div>
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="images" class="col-sm-12 col-md-12">images de l'événement : </label>
    <input type="file" name="images" id="images" class="form-control">
    <button id="uploadBtn"  type="button" class="browse form-control btn btn-primary">Choisir une image</button>
    @error('image') <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div> @enderror
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <img id="preview" src="{{ route('show_image',@$event->images) }}" alt="{{@$event->title}}" style="width:50%; height: auto">
</div>
<div class="col-12"><hr/></div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="category_id" class="col-sm-12 col-md-12">Categorie de l'événement : </label>
    <select name="category_id" id="category_id" class="form-control">
        <option value=""> --- </option>
        @foreach($categories as $category)
            <option value="{{$category->id}}" {{intval(old('category_id',@$event->category_id)) === $category->id?'selected':''}}> {{$category->name}} </option>
        @endforeach
    </select>
    {!! $errors->first('category_id', '<div class="error-message col-12">:message</div>') !!}
</div>
<div class="offset-sm-0 col-sm-12 col-md-6 form-group row">
    <label for="publication_status" class="col-sm-12 col-md-12">Statut de lannonce : * </label>
    <select name="publication_status" id="publication_status" class="form-control">
        <option value=""> --- </option>
        @forelse($status as $key => $statu)
            <option value="{{$key}}" {{intval(old('publication_status',@$event->publication_status)) === $key ? "selected":"" }}>{{$statu}}</option>
        @empty
        @endforelse
    </select>
    {!! $errors->first('publication_status', '<div class="error-message col-12">:message</div>') !!}
</div>


<div id="HoursPickupModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Veuillez sélectionner les heures pour chaque dates</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="/membres/send_registration" method="post" accept-charset="utf-8">
                    <div class="form-group hourselection row">
                        <label for="username" class="col-sm-4  control-label">Heure pour tous: </label>
                        <div class="col-sm-3 input-group clockpickerall" data-placement="left" data-align="top" data-autoclose="true">
                            <input type="text" class="form-control " value="09:30">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <div id="themodal"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary SaveFinalDate">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>


<div id="AjoutFinaliseModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Finaliser l'ajout d'événements</h4>
            </div>
            <div class="modal-body" id="FinaliseModalBody">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <strong>L'ajout de cet événement vous coutera :</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">



                        <table class="table text-left">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>Votre solde actuel:</strong>
                                    </td>
                                    <td class="smcalcul">(
                                        <span class="f-actual-solde"></span> crédits)</td>
                                    <td>
                                        <span class="f-actual-solde"></span> crédits</td>

                                </tr>
                                <tr>
                                    <td>
                                        <strong>Coût de base:</strong>
                                    </td>
                                    <td class="smcalcul">(1 montage/date x
                                        <span class="f-montage-price"></span> crédits)</td>
                                    <td>-
                                        <span class="f-montage-price"></span> crédits </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Coût extra:</strong>
                                    </td>
                                    <td class="smcalcul">(
                                        <span class="f-nombre-dates"></span> dates additionnelles x
                                        <span class="f-dates-price-each"></span> crédits)</td>
                                    <td>-
                                        <span class="f-dates-price"></span> crédits </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Coût Total:</strong>
                                    </td>
                                    <td class="smcalcul">(
                                        <span class="f-dates-price"></span> +
                                        <span class="f-montage-price"></span> crédits)</td>
                                    <td>
                                        <strong></strong>-
                                        <span class="f-total-price"></span> crédits</td>
                                </tr>
                                <tr style="border-top:2px #000 solid;">
                                    <td>
                                        <strong>Votre solde final:</strong>
                                    </td>
                                    <td class="smcalcul">(
                                        <span class="f-actual-solde"></span> -
                                        <span class="f-total-price"></span> crédits)</td>
                                    <td style="color:#01a8df;">
                                        <strong>
                                            <span class="f-final-solde"></span> crédits</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </table>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="f-final-text alert" role="alert"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default event-finalize-button" data-dismiss="modal">Rafraîchir le solde actuel</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Retour</button>
                <button type="button" class="btn btn-primary FinalizeEvent">Finaliser</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>