@extends('layouts.back.admin')

@section('title','Creation de fonctions')

@section('content')
    <form method="POST" action="{{route('admin.settings.security.roles.index')}}" accept-charset="UTF-8">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <div class="row">
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
          <div class="col-sm-12 col-md-8">
              <div class="card">
                  <div class="card-header bg-primary">
                      <h2 class="card-title font-weight-bold">Informations de base</h2>
                  </div>
                  <div class="card-body row">
                      <div class="col-12 form-group row">
                      <label for="Nom du groupe *" class="col-sm-12 col-md-3">Nom Du Groupe *</label>
                      <input class="col-sm-12 col-md-9" name="name" type="text" value="">
                        {!! $errors->first('name', '<div class="error-message col-12">:message</div>') !!}
                      </div>
                      <div class="col-12 form-group row">
                      <label for="Evenements Gratuits" class="col-sm-12 col-md-3">Evenements Gratuits</label>
                      <input class="col-sm-12 col-md-9" name="free_events" type="checkbox" value="1">
                      </div>
                      <div class="col-12 form-group row">
                      <label for="Annonces Gratuites" class="col-sm-12 col-md-3">Annonces Gratuites</label>
                      <input class="col-sm-12 col-md-9" name="free_annoncements" type="checkbox" value="1">
                      </div>
                      <div class="col-6 form-group row">
                      <label for="Prix par événement" class="col-sm-12 col-md-6">Prix Par événement</label>
                        <div class="input-group mb-3 col-sm-12 col-md-6">
                        <input class="form-control" min="10" name="events_price" type="number" value="500">
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon1">Crédits</span>
                            </div>
                        </div>
                        {!! $errors->first('events_price', '<div class="error-message col-12">:message</div>') !!}
                      </div>
                      <div class="col-6 form-group row">
                      <label for="Date " class="col-sm-12 col-md-6 text-right">Date </label>
                        <div class="input-group mb-3 col-sm-12 col-md-6">
                        <input class="form-control" min="1" name="date_credit" type="number" value="1">
                          <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">Crédits</span>
                          </div>
                        </div>
                        {!! $errors->first('date_credit', '<div class="error-message col-12">:message</div>') !!}
                      </div>
                      <div class="col-12 form-group row">
                      <label for="Prix par annonce" class="col-sm-12 col-md-3">Prix Par Annonce</label>
                        <div class="input-group mb-3 col-sm-12 col-md-9">
                        <input class="form-control" min="10" name="annoucements_price" type="number" value="100">
                              <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon3">Crédits</span>
                              </div>
                        </div>
                        {!! $errors->first('annoucements_price', '<div class="error-message col-12">:message</div>') !!}
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-sm-12 col-md-4"> <!-- column to add prices -->
            <div class="card">
                  <div class="card-header bg-primary">
                      <h2 class="card-title font-weight-bold">Liste des prix</h2>
                  </div>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-6">
                          <label for="Prix $" class="col-sm-12">Prix $</label>
                        </div>
                        <div class="col-xm-6">
                          <label for="Credits" class="col-sm-12">Credits</label>
                        </div>
                        <div id="credit_price_wrapper"></div>
                        <input type="hidden" name="nbr_price_fields" id="nbr_price_fields" value="0" />
                        <div class="col-12 my-5 justify-content-center row">
                          <button type="button" name="add_credit_price" id="add_credit_price" class="btn btn-primary">Ajouter un prix</button>
                        </div>
                      </div>
                  </div>
            </div>
          </div>
          <div class="col-sm-12">
              <div class="card">
                  <div class="card-header bg-primary">
                      <h2 class="card-title font-weight-bold">Permissions</h2>
                  </div>
                  <div class="card-body row">
                    @foreach($permission_array as $key => $groupe)
                      <div class="col-4 form-group border row px-4">
                        <h4 class="col-12">{{$groupe}}</h4>
                        @foreach($permissions as $permission)
                          @if($permission->permission_group == strtolower($key))
                            <div class="col-12">
                              <input class="col-sm-2" id="all" name="{{'permission_'.$permission->id}}" type="checkbox" value="{{$permission->id}}">
                              <label for="permission_{{$permission->id}}" style="font-weight: normal;" col="col-sm-10">{{$permission->name}}</label>
                            </div>
                          @endif
                        @endforeach
                      </div>
                    @endforeach
                  </div>
              </div>
          </div>
          <div class="col justify-content-end row justify-content-end m-2">
            <button type="submit" name="save" class="btn btn-primary">
              <i class="fa fa-register"></i>Enregistrer
            </button>
          </div>
      </div>
    </form>
@stop
@push('scripts')

    <script>
        $(function() {
           $("#add_credit_price").on("click", function(e){
             e.preventDefault();
             
             $nbr = parseInt($("#nbr_price_fields").val());//We get the that help us know how many price is set
             ++$nbr;
             $("#nbr_price_fields").val($nbr);//we set the new value for the field

             $fields = `<div class="justify-content-between row my-2" id="price_wrapper-${$nbr}">
             <input class="form-control col-sm-5" name="price-${$nbr}" id="price-${$nbr}" type="number" value="">
             <input class="form-control col-sm-5" name="credit_amount-${$nbr}" id="credit_amount-${$nbr}" type="number" value=""><button class="btn btn-danger delete-price" data-target="price_wrapper-${$nbr}" id="delete-price-${$nbr}"><i class="fa fa-trash"></i></button> </div>`;
            $("#credit_price_wrapper").append($fields);

           });
        });
    </script>

@endpush
