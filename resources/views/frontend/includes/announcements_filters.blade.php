<form class="col-sm-12 col-md-12 justify-content-center row p-0 bg-light datatable-filter mb-2">
    <!-- <div class="row form-group datatable-filter"> -->
    <div class="col-sm-12 col-md-2 px-0">
        <label><small>Titre :</small><a href="#" class="reset-field" data-target="#filter_title">x</a></label>
        <input  id='filter_title' type="text" name="title" placeholder="" class="form-control" />
    </div>
    <div class="col-sm-12 col-md-2 px-0">
        <label><small>Régions :</small><a href="#" class="reset-field" data-target="#filter_region_id">x</a></label>
        <select id='filter_region_id' class="form-control">
            <option value=""> --- </option>
            @foreach($regions as $key => $region)
                <option value="{{$region->id}}">{{$region->region_number}} {{$region->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-12 col-md-2 px-0">
        <label><small> Villes :</small><a href="#" class="reset-field" data-target="#filter_city_id">x</a></label>
        <select id='filter_city_id' class="form-control">
            <option value=""> --- </option>
            @foreach($cities as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-12 col-md-1 px-0">
        <label><small>Code postal :</small><a href="#" class="reset-field" data-target="#filter_postal_code_id">x</a></label>
        <input class="form-control" id='filter_postal_code_id' type="text" name="postal_code" placeholder="" />
    </div>
</form>

<script defer>
        $(function() {
   
            /* *  load the date picker **/
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
            const regions = document.getElementById("region_id");
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
            
            $('.dt-buttons').append(' - <button class="dt-button buttons-csv buttons-html5 btn btn-success m-0" tabindex="0" aria-controls="announcements-table" type="button" id="reset_filter"><span><i class="fa fa-broom"></i>Effacer les filtres</span></button>');
        });
</script>