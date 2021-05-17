@extends('layouts.back.admin')

@section('title','Ajout d'une fonction')
@section('page_title','Ajout d'une fonction')

@section('content')
    @if(Route::currentRouteName() == 'admin.settings.security.roles.create')
      {!! Form::model($role, ['route' => ['admin.settings.security.roles.index']]) !!}
    @endif
    @if(Route::currentRouteName() == 'admin.settings.security.roles.edit')
      {!! Form::model($role, ['route' => ['admin.settings.security.roles.update', $role->id]]) !!}
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="card-title font-weight-bold">Informations de base</h2>
                </div>
                <div class="card-body row">
                    <div class="col-12 form-group row">
                      {!! Form::label('Nom du groupe *','', ['class' => 'col-sm-12 col-md-3']) !!}
                      {!! Form::input("text",'name','',['class'=>'col-sm-12 col-md-9']) !!}
                      {!! $errors->first('name', '<div class="error-message col-12">:message</div>') !!}
                    </div>
                    <div class="col-12 form-group row">
                      {!! Form::label('Événements Gratuits','', ['class' => 'col-sm-12 col-md-3']) !!}
                      {!! Form::checkbox('free_events',1,false,['class'=>'col-sm-12 col-md-9']) !!}
                    </div>
                    <div class="col-12 form-group row">
                      {!! Form::label('Annonces Gratuites','', ['class' => 'col-sm-12 col-md-3']) !!}
                      {!! Form::checkbox('free_annoncements',1,false,['class'=>'col-sm-12 col-md-9']) !!}
                    </div>
                    <div class="col-6 form-group row">
                      {!! Form::label('Prix par événement','', ['class' => 'col-sm-12 col-md-6']) !!}
                      <div class="input-group mb-3 col-sm-12 col-md-6">
                        {!! Form::input("number",'event_price',"500",['class'=>'form-control','min' => 10]) !!}
                          <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon1">Crédits</span>
                          </div>
                      </div>
                      {!! $errors->first('event_price', '<div class="error-message col-12">:message</div>') !!}
                    </div>
                    <div class="col-6 form-group row">
                      {!! Form::label('Date ','', ['class' => 'col-sm-12 col-md-6 text-right']) !!}
                      <div class="input-group mb-3 col-sm-12 col-md-6">
                        {!! Form::input("number",'date_credit','1',['class'=>'form-control','min' => 1]) !!}
                        <div class="input-group-append">
                          <span class="input-group-text" id="basic-addon2">Crédits</span>
                        </div>
                      </div>
                      {!! $errors->first('date_credit', '<div class="error-message col-12">:message</div>') !!}
                    </div>
                    <div class="col-12 form-group row">
                      {!! Form::label('Prix par annonce','', ['class' => 'col-sm-12 col-md-3']) !!}
                      <div class="input-group mb-3 col-sm-12 col-md-9">
                        {!! Form::input("number",'announcement_price','100', ['class'=> 'form-control', 'min' => 10]) !!}
                            <div class="input-group-append">
                              <span class="input-group-text" id="basic-addon3">Crédits</span>
                            </div>
                      </div>
                      {!! $errors->first('announcement_price', '<div class="error-message col-12">:message</div>') !!}
                    </div>
                </div>
                <!-- @if(Route::currentRouteName() == 'admin.settings.security.roles.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.security.roles.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer un nouveau rôle
                        </a>
                    </div>
                @endif -->
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
                        {!! Form::label('Prix $',`<text>`, ['class' => 'col-sm-12']) !!}
                      </div>
                      <div class="col-xm-6">
                        {!! Form::label('Credits','', ['class' => 'col-sm-12']) !!}
                      </div>
                      <div id="credit_price_wrapper"></div>
                      <input type="hidden" name="nbr_price_fields" id="nbr_price_fields" value="0" />
                      <!-- <div class="justify-content-between row">
                        {!! Form::input("text",'price-x','',['class'=>'form-control col-sm-5']) !!}
                        {!! Form::input("text",'price-x','',['class'=>'form-control col-sm-5']) !!}
                        <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                      </div> -->
                      <div class="col-12 my-5 justify-content-center row">
                        <button type="button" name="add_credit_price" id="add_credit_price" class="btn btn-primary">Ajouter un prix</button>
                      </div>
                    </div>
                    <!-- { !! form($form) !!} -->
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
                            {!! Form::checkbox("permission_".$permission->id,$permission->id,false,['class'=>'col-sm-2','id' => $permission->name]) !!}
                            {!! Form::label("permission_".$permission->id, $permission->name , ['style' => 'font-weight: normal;',"col" => "col-sm-10"]) !!}
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
    {!! Form::close() !!}
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
             <input class="form-control col-sm-5" name="credit_amount-${$nbr}" id="credit_amount-${$nbr}" type="number" value=""><button class="btn btn-danger" data-target="price_wrapper-${$nbr}"><i class="fa fa-trash"></i></button> </div>`;
            $("#credit_price_wrapper").append($fields);

           });
          /*$('#roles-table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{{ url('admin/settings/security/get-role-data') }}',
              columns: [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'users_count', name: 'users_count' },
                  { data: 'updated_at', name: 'updated_at' },
                  { data: 'action', name: 'action', orderable: false, searchable: false }
              ]
          });
          $('#modal-delete').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget) // Button that triggered the modal
              var link = button.data('whatever') // Extract info from data-* attributes
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
              var modal = $(this)
              modal.find('.yes-delete-btn').attr({'href' : link})
          })*/
        });
    </script>

@endpush
