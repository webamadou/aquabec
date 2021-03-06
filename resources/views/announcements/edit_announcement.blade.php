@extends('layouts.front.app')
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css"> 
@section('content')
    <div class="row">
        <div class="offset-sm-2 col-10 text-blue mb-4"><h2><i class="fa fa-plus"></i> Modification de l'annonce {{$announcement->title}}</h2></div>
        <div class="col-8 tab-content mx-auto" id="nav-tabContent">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">- </h2>
                </div>
                <div class="card-body">
                    <form action="{{route('user.update_announcement', $announcement)}}" method="post" enctype="multipart/form-data">
                        <div class="row">
                            @csrf
                            @method("PUT")
                            @if($user->hasAnyRole(['chef-vendeur','vendeur']))
                            <div class="offset-sm-0 col-12 form-group row">
                                <label for="owner" class="col-sm-12 col-md-12">Publiée l'annonce pour : </label>
                                <select name="owner" id="owner" class="form-control">
                                    <option value=""> --- </option>
                                    @forelse($children as $child)
                                    <option value="{{$child->id}}"> {{$child->name}} </option>
                                    @empty
                                    <option value="{{$user->id}}">Vous n'avez enregistré aucun équipier.</option>
                                    @endforelse
                                </select>
                            </div>
                            @endif
                            <input type="hidden" name="posted_by" value="{{$user->id}}">
                            @include("announcements.includes.announcement_form")
                            <div class="col-sm-4 form-group row mt-5 mr-2">
                                <a href="{{route('user.show_announcement',$announcement->slug)}}" class="btn btn-success"><i class="fa fa-reply"></i> Annuler</a>
                            </div>
                            <div class="col-sm-7 form-group row mt-5">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer</button>
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
    <script>
        $(document).ready(function(){  
            $('#datePick').multiDatesPicker({
                dateFormat: "d/m/yy",
                minDate: 0, // today
            });

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

    <script src="{{asset('/dist/ckeditor/ckeditor.js')}}" defer></script>
    <script>
            //Load of ckeditor
            $(document).ready(function () {
                $('.ckeditor').ckeditor();
            });
    </script>
@endpush