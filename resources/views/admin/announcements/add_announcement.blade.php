@extends('layouts.back.admin')

@section('title',"Ajout d'une annonce en backoffice")
@section('page_title','Ajout d'une annonce en backoffice')

<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"> 
@section('content')
    <div class="row">
        <div class="offset-sm-2 col-10 text-blue mb-4"><h2><i class="fa fa-plus"></i> Ajout d'une annonce classée (le montage) </h2></div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(!$can_post)
            <div class="badge text-danger badge-light mb-4 py-2" style="line-height: 2.4;">
                Vous n'avez pas assez de <strong>{{strtolower(@$role_currency->name)}}</strong> dans votre portefeuille pour publier votre annonce.<br>Vous pouvez tout de même l'enregistrer en brouillon. Vous pouvez aussi
            </div>
        @endif
        <div class="col-8 tab-content mx-auto" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">- </h2>
                    <div class="card-tools">
                        <a href="{{route('admin.announcements')}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-reply"></i> Retour vers la liste
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{route('admin.store_announcement')}}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            @if($user->hasAnyRole(['chef-vendeur','vendeur']))
                            <div class="offset-sm-0 col-12 form-group row">
                                <label for="owner" class="col-sm-12 col-md-12">Publiée l'annonce pour : </label>
                                <select name="owner" id="owner" class="form-control">
                                    <option value=""> --- </option>
                                    @forelse($children as $child)
                                    <option value="{{$child->id}}" {{old("owner",@$event->owner) == $child->id?'selected':'' }}> {{$child->username}} </option>
                                    @empty
                                    <option value="{{$user->id}}">Vous n'avez enregistré aucun équipier.</option>
                                    @endforelse
                                </select>
                            </div>
                            @endif
                            <input type="hidden" name="posted_by" value="{{$user->id}}">
                            @include("announcements.includes.announcement_form")
                            <hr class="my-2">
                            @if(!empty(@$user_events))
                                <div id="" class="bg-lightblue col-md-12 col-sm-12 form-group py-2 row">
                                    <label for="title" class="col-sm-12 col-md-12"><strong>Lier l'annonce à un événement :*</strong> </label>
                                    <select name="event_id" id="event_id" class="form-control col-sm-12 col-md-6">
                                        <option value=""> --- </option>
                                        @foreach($user_events as $key => $title)
                                            <option value="{{$key}}" {{intval(old('event_id',@$announcement->event_id)) === $key ? 'selected' : ''}}> {{$title}} </option>
                                        @endforeach
                                    </select>
                                    <div class="col-sm-12 col-md-6">
                                        <label for="new_event">Ou ajouter un nouvel événement</label> <input type="checkbox" name="new_event" value="1" id="new_event" />
                                    </div>
                                </div>
                            @endif
                            <div class="offset-sm-4 col-sm-8 form-group row">
                                <button id="new_event_wrapper" class="btn btn-success" type="submit">Lier un nouvel événement <i class="fa fa-angle-double-right"></i>  <br><small>Créer un nouvel événement qui sera lier à votre annonce.</small></button>
                                <button id="save_announcement" type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" defer></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" defer></script>
    <script src="{{asset('dist/multiple_dates_picker/jquery-ui.multidatespicker.js')}}" defer></script>
    <script defer>
        $(document).ready(function(){
            //processing upload of image
            $(document).on("click", ".browse", function () {
                let file = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find("#images");
                file.trigger("click");
            });
            $('input[type="file"]').on('change', function (e) {
                let fileName = e.target.files[0].name;
                $("#file").val(fileName);

                let reader = new FileReader();
                reader.onload = function (e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("preview").src = e.target.result;
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            });

            $('#datePick').multiDatesPicker({
                dateFormat: "d/m/yy",
                minDate: 0, // today
            });
            //COntrolling the displaying of the create new event btn
            function toggleNewEventBtn() {
                const new_event = document.getElementById("new_event");
                if (new_event.checked) {
                    $('#new_event_wrapper').addClass("active");
                    $('#save_announcement').hide();
                    $('#event_id').val('').change();
                    $('#event_id').hide();
                } else {
                    $('#new_event_wrapper').removeClass("active");
                    $('#event_id').show();
                    $('#save_announcement').show();
                }
            }
            const new_event = document.getElementById("new_event") ;
            if(new_event !== null){
                new_event.addEventListener('change', function (event) {
                    toggleNewEventBtn();
                });
            }

            //*** Select the price type ***
            const price_type = document.getElementById("price_type");
            if(price_type !== null){
                price_type.addEventListener('change',function(e){
                    const val = this.value;
                    let display_status = '';
                    switch (parseInt(val)) {
                        case 1:
                            display_status = "initial";
                            break;
                    
                        default:
                            display_status = "none";
                            break;
                    }

                    document.getElementById("price_field_wrapper").style.display = display_status;
                });
            }

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