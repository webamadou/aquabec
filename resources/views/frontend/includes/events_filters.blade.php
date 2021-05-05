<form class="col-sm-12 col-md-12 justify-content-center row p-0 bg-light datatable-filter mb-2">
    <!-- <div class="row form-group datatable-filter"> -->
    <div class="col-sm-12 col-md-2 px-0">
        <label><small>Id :</small><a href="#" class="reset-field" data-target="#filter__id">x</a></label>
        <input  id='filter__id' type="text" name="id" placeholder="" class="form-control" />
    </div>
    <div class="col-sm-12 col-md-2 px-0">
        <label><small>Date :</small><a href="#" class="reset-field" data-target="#filter__date">x</a></label>
        <input  id='filter__date' type="text" name="dates" placeholder="" class="form-control" />
    </div>

    <!-- <div class="col-sm-12 col-md-2 px-0">
        <label><small>Régions :</small><a href="#" class="reset-field" data-target="#filter_region_id">x</a></label>
        <select id='filter_region_id' class="form-control">
            <option value=""> --- </option>
            @foreach($regions as $key => $region)
                <option value="{{$region->id}}">{{$region->region_number}} {{$region->name}}</option>
            @endforeach
        </select>
    </div> -->
    <div class="col-sm-12 col-md-2 px-0">
        <label><small> Villes :</small><a href="#" class="reset-field" data-target="#filter_city_id">x</a></label>
        <select id='filter_city_id' class="form-control">
            <option value=""> --- </option>
            @foreach($cities as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-sm-12 col-md-2 px-0">
        <label><small> Ajouté par :</small><a href="#" class="reset-field" data-target="#annonceur_filter">x</a></label>
        <select id='annonceur_filter' class="form-control">
            <option value=""> --- </option>
            @foreach($list_users as $user)
                <option value="{{$user->id}}"><i class="fa fa-user-circle-o"></i> {{$user->username}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-12 col-md-2 px-0">
        <label><small>Publiée le :</small><a href="#" class="reset-field" data-target="#filter_created_at">x</a></label>
        <input class="form-control" id='filter_created_at' type="text" name="id" placeholder="Ex: 2021-04-28" />
    </div>
</form>

<script defer>
        $(function() {
   
            /* *  load the date picker *2222    */
            $('#filter_date_min_id,#filter_date_max_id').datepicker({
                clearBtn: true,
                language: "fr"
            });
            //*** Select the price type ***
            const price_type = document.getElementById("price_type");
            if(price_type !== null){
                price_type.addEventListener('change',function(e){
                    const val = this.value;
                    let display_status = 'none';
                    switch (parseInt(val)) {
                        case 1:{
                            display_status = "initial";
                            break;
                        }
                        default:{
                            document.getElementById("filter_price_min_id").value = ""
                            document.getElementById("filter_price_max_id").value = ""
                            display_status = "none";
                            break;
                        }
                    }

                    /*alert(val,display_status);*/
                    document.getElementById("min-price").style.display = display_status;
                    document.getElementById("max-price").style.display = display_status;
                });
            }

            //*** Select the cities of the selected region ***
            const regions = document.getElementById("filter_region_id");
            if(regions != null){
                document.getElementById("filter_region_id").addEventListener('change', function (event) {
                    const selected_region = this.value;
                    $.ajax({
                        type: 'get',
                        url: `{{url('/select_cities')}}`,
                        data: {'id': selected_region},
                        success: function(res){
                            const entries = Object.entries(res);
                            const cities_field = document.getElementById("filter_city_id");
                            cities_field.innerHTML = `<option value=""> --- </option>`;
                            for(const [key,region] of entries){
                                console.log(key);
                                cities_field.innerHTML += `<option value="${key}">${region}</option>`;
                            }
                        }
                    });
                });
            }

            
        });
</script>