@extends('layouts.front.app')

@section('title','Modification des information du profil de '.$user->prenom.' '.$user->name)

@section('content')
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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold"> - </h2>
                    <div class="card-tools">
                        <a href="{{route('vendeurs.show_vendeur',@$user->slug)}}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-user-circle"></i>
                            Afficher le profil
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('vendeurs.update_vendeur',$user)}}" method="post">
                        @method('PUT')
                        <input type="hidden" name="godfather" id="godfather" value="{{$current_user->id}}">
                        <input type="hidden" name="id" id="id" value="{{$user->id}}">
                        <input type="hidden" name="role_vendeur" id="role_vendeur" value="vendeur">
                        @include('user.vendeurs.includes.form')
                        @method('PUT')
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.back.alerts.delete-confirmation')

@stop
@push('scripts')

    <script defer>
        $(function() {

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