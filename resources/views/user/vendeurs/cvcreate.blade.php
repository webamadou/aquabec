@extends('layouts.front.app')

@section('title',@$title)

@section('content')
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger alert-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-sm-12">
            <div class="card">
                <form action="{{route('vendeurs.store_vendeur')}}" method="post">
                    <input type="hidden" name="godfather" id="godfather" value="{{$current_user->id}}">
                    @hasanyrole('chef-vendeur')
                        <input type="hidden" name="role_vendeur" id="role_vendeur" value="vendeur">
                    @endrole
                    @hasanyrole('vendeur')
                        <input type="hidden" name="role_annonceur" id="role_annonceur" value="annonceur">
                    @endrole
                    @include('user.vendeurs.includes.form')
                </form>
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