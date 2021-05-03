@extends('layouts.back.admin')

@section('title',"Modification d'une fonction")

@section('content')
    <form method="POST" action="{{route('admin.settings.security.roles.update', $role)}}" accept-charset="UTF-8">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <input name="_method" type="hidden" value="PUT">
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h2 class="card-title font-weight-bold">Informations de base</h2>
                        <div class="card-tools">
                            <a href="{{route('admin.settings.security.roles.index')}}" class="btn btn-success"><i class="fa fa-angle-double-left"></i> Retourner vers la liste</a>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12 form-group row">
                            <label for="name" class="col-sm-12 col-md-3">Nom de la fonction *</label>
                            <input class="col-sm-12 col-md-9" name="name" type="text" value="{{$role->name}}">
                            {!! $errors->first('name', '<div class="error-message col-12">:message</div>') !!}
                        </div>
                        <div class="col-12 form-group row justify-content-center bg-light">
                            <label for="free_events" class="col-sm-6 col-md-6">Événements Gratuits</label>
                            <label class="label col-sm-6 col-md-6">
                                <input class="label__checkbox" id="free_events" name="free_events" type="checkbox" value="1" {{ $role->free_events>=1 ?"checked": "" }}>
                                <span class="label__text">
                                <span class="label__check">
                                    <i class="fa fa-check icon"></i>
                                </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-12 form-group row justify-content-center bg-light">
                            <label for="free_annoncements" class="col-sm-6 col-md-6">Annonces Gratuites</label>
                            <label class="label col-sm-6 col-md-6">
                                <input class="label__checkbox" name="free_annoncements" type="checkbox" value="1" {{ $role->free_annoncements >= 1 ?"checked": "" }}>
                                <span class="label__text">
                                    <span class="label__check">
                                    <i class="fa fa-check icon"></i>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-6 form-group row">
                            <label for="events_price" class="col-sm-12 col-md-6">Prix Par événement</label>
                            <div class="input-group mb-3 col-sm-12 col-md-6">
                                <input class="form-control" name="events_price" type="number" value="{{$role->events_price}}">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-coins"></i> </span>
                                </div>
                            </div>
                            {!! $errors->first('events_price', '<div class="error-message col-12">:message</div>') !!}
                        </div>
                        <div class="col-6 form-group row">
                            <label for="date " class="col-sm-12 col-md-6 text-right">Date </label>
                            <div class="input-group mb-3 col-sm-12 col-md-6">
                                <input class="form-control" min="1" name="date_credit" id="date_credit" type="number" value="{{$role->date_credit}}">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-coins"></i> </span>
                                </div>
                            </div>
                            {!! $errors->first('date_credit', '<div class="error-message col-12">:message</div>') !!}
                        </div>
                        <div class="col-12 form-group row">
                            <label for="Prix par annonce" class="col-sm-12 col-md-3">Prix Par Annonce</label>
                            <div class="input-group mb-3 col-sm-12 col-md-9">
                                <input class="form-control" name="annoucements_price" id="annoucements_price" type="number" value="{{$role->annoucements_price}}">
                                <div class="input-group-append"> <span class="input-group-text" id="basic-addon3"><i class="fa fa-coins"></i> </span> </div>
                            </div>
                            {!! $errors->first('annoucements_price', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-12 row bg-gradient-light">
                            <div class="col-md-6 col-sm-12">
                                <label for="free_credit" class="col-md-12">Monnaie de la fonction</label>
                                <div class="input-group mb-3 col-md-12 col-sm-6">
                                <select name="currency_id" id="currency_id" class="form-control">
                                    <option value="">Sélectionnez la monnaie pour cette fonction.</option>
                                    @foreach($currencies as $key => $currency)
                                    <option value="{{$key}}" {{old('currency_id',$role->currency_id)==$key?"selected":""}}>{{$currency}}</option>
                                    @endforeach
                                </select>
                                </div>
                                {!! $errors->first('free_credit', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label for="paid_credit" class="col-md-12"> Montant gratuit </label>
                                <div class="input-group mb-3 col-md-12 col-sm-6">
                                    <input class="form-control" min="0" name="free_credit" type="number" value="{{old('free_credit',$role->free_credit)}}">
                                </div>
                                {!! $errors->first('paid_credit', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <label for="paid_credit" class="col-md-12"> Montant payant </label>
                                <div class="input-group mb-3 col-md-12 col-sm-6">
                                    <input class="form-control" min="0" name="paid_credit" type="number" value="{{old('paid_credit',$role->paid_credit)}}">
                                </div>
                                {!! $errors->first('paid_credit', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4"> <!-- column to add prices -->
                <div class="card" id="description-card">
                    <div class="card-header bg-primary">
                        <h2 class="card-title font-weight-bold">Description</h2>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <textarea class="form-control ckeditor" name="description" id="description" cols="30" rows="5" placeholder="ajouter une description de la fonction">{{old('description',$role->description)}}</textarea>
                        </div>
                    </div>
                </div>
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
                                <label for="Credits" class="col-sm-12">Montant</label>
                            </div>
                            <div id="credit_price_wrapper">
                                @foreach($role->credit_prices as $key => $price)
                                    @php ++$key @endphp
                                    <div class="justify-content-between row my-2 price-line" id="price_wrapper-{{$key}}" data-children-count="{{2}}" data-price_id="{{$price->id}}">
                                        <input type="hidden" name="credit_id-{{$key}}" value="{{$price->id}}" class="id_input">
                                        <input class="price_field form-control col-sm-5" name="price-{{$key}}" id="price-{{$key}}" type="number" value="{{$price->price}}">
                                        <input class="credit_amount_field form-control col-sm-5" name="credit_amount-{{$key}}" id="credit_amount-{{$key}}" type="number" value="{{$price->credit_amount}}">
                                        <button type="button" class="btn btn-danger delete-price" data-target="price_wrapper-{{$key}}" id="delete-price-{{$key}}" data-price_id="{{$price->id}}"><i class="fa fa-trash"></i></button>
                                    </div>
                                @endforeach
                            </div>
                            <input class="price_deleted form-control col-sm-5" name="prices_deleted" type="hidden" value="">
                            <input type="hidden" name="nbr_price_fields" id="nbr_price_fields" value="{{$role->credit_prices->count()}}" />
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
                                <!-- <input class="col-sm-2" id="$permission->name" name="permission_{{$permission->id}}" type="checkbox" value="{{$permission->id}}" {{ $role->hasPermissionTo($permission->name) ?"checked": "" }}>
                                <label for="permission_{{$permission->id}}" style="font-weight: normal;" col="col-sm-10">{{$permission->name}}</label> -->
                              <label class="label">
                                <!-- <input class="col-sm-2 label__checkbox" id="{{'permission_'.$permission->id}}" name="{{'permission_'.$permission->id}}" type="checkbox" value="{{$permission->id}}"> -->
                                <input class="label__checkbox" id="permission_{{$permission->id}}" name="permission_{{$permission->id}}" type="checkbox" value="{{$permission->id}}" {{ $role->hasPermissionTo($permission->name) ?"checked": "" }}>
                                <span class="label__text">
                                  <span class="label__check">
                                    <i class="fa fa-check icon"></i>
                                  </span>
                                </span>
                              </label>
                              <label for="permission_{{$permission->id}}" style="font-weight: normal;" class="">{{$permission->name}}</label>

                            </div>
                            @endif
                        @endforeach
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="col justify-content-end row justify-content-end m-2">
            <button type="submit" name="save" class="btn btn-lg btn-block btn-primary">
                <i class="fa fa-save"></i> Enregistrer les modifications
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

            $fields = `<div class="justify-content-between row my-2 price-line" id="price_wrapper-${$nbr}">
                <input class="price_field form-control col-sm-5" name="price-${$nbr}" id="price-${$nbr}" type="number" value="">
                <input class="credit_amount_field form-control col-sm-5" name="credit_amount-${$nbr}" id="credit_amount-${$nbr}" type="number" value=""><button type="button" class="btn btn-danger delete-price" data-target="price_wrapper-${$nbr}" id="delete-price-${$nbr}"><i class="fa fa-trash"></i></button> </div>`;
            $("#credit_price_wrapper").append($fields);

           });

            //Here we handle the actions when delete price is clicked
            $("body").on("click",".delete-price", function(e){
                e.preventDefault()
                const line_index    = $(this).data("target");
                const current_index = parseInt($(this).data("target").replace("price_wrapper-", ''));
                const nbr_fields    = parseInt($("#nbr_price_fields").val());
                const price_id      = $(this).data("price_id");
                //If we have a price_id that means we need to add the id to the field of prices to deleted on the DB
                if(price_id){
                    $("input[name='prices_deleted'").val($("input[name='prices_deleted'").val()+','+price_id);
                }
                //Now we need check the index that is being deleted and update folling fields if any
                //If currenct_index - nbr_fields > 0 that means there are other fields after the deleted one
                if(nbr_fields - current_index > 0){
                    const next_index = current_index + 1;
                    for (let i = current_index; i <= nbr_fields; i++) {
                        $(`#price_wrapper-${next_index} #price-${next_index}`).attr("name",`price-${i}`);
                        $(`#price_wrapper-${next_index} #price-${next_index}`).attr("id",`price-${i}`);
                        $(`#price_wrapper-${next_index} #credit_amount-${next_index}`).attr("name",`credit_amount-${i}`);
                        $(`#price_wrapper-${next_index} #credit_amount-${next_index}`).attr("id",`credit_amount-${i}`);
                        $(`#price_wrapper-${next_index} button`).attr('data-target',`price_wrapper-${i}`);
                        $(`#price_wrapper-${next_index} button`).attr('id',`delete-price-${i}`);

                        $(`#price_wrapper-${next_index} input[name="credit_id-${next_index}"]`).attr("name",`credit_id-${i}`);
                        $(`#price_wrapper-${next_index}`).attr("id",`price_wrapper-${i}`);
                    }
                }
                //Now we update the nbr field
                $("#nbr_price_fields").val(nbr_fields - 1);
                //And remove the element
                $(`#price_wrapper-${current_index}`).remove();
            });

        });
    </script>

@endpush
