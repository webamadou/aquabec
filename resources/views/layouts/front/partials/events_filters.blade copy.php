<div class="row form-group datatable-filter my-2 py-4">
    <div class="col-sm-12 col-md-8 justify-content-left row p-0 bg-light">
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Régions :</small></label>
            <select id='filter_region_id' class="form-control">
                <option value=""> --- </option>
                @foreach($regions as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small> Villes :</small></label>
            <select id='filter_city_id' class="form-control">
                <option value=""> --- </option>
                @foreach($cities as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small> Organisateurs :</small></label>
            <select id='filter_organisation_id' class="form-control">
                <option value=""> --- </option>
                @foreach($organisations as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Type de publication :</small></label>
            <select id='filter_publication_type_id' class="form-control">
                <option value=""> --- </option>
                <option value="0"> Enregistrée en brouillon </option>
                <option value="1"> Publiée </option>
                <option value="2"> Enregistrée en privé </option>
            </select>
        </div>
        <!-- <div class="col-sm-12 col-md-2 px-0">
            <label><small>Code postal :</small></label>
            <input  id='filter_postal_code_id' type="text" name="postal_code" placeholder --- ostal" />
        </div> -->
    </div>
    <div class="col-sm-12 col-md-4 justify-content-end row p-0 bg-light"><!-- dates filters -->
        <div class="col-sm-12 col-md-6 px-0">
            <label for="filterdates"> --- </label>
            <div class="input-group-filter-min date">
                <input type="text" class="form-control" id="filter_date_min_id"/>
                <!-- <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span> -->
            </div>
        </div>
        <!-- <div class="col-sm-12 col-md-6 px-0">
            <label for="filterdates"><small>&nbsp;</small></label>
            <div class="input-group-filter-max date">
                <input type="text" class="form-control" id="filter_date_max_id" />
                < !-- <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span> - ->
            </div>
        </div> -->
    </div>
</div>
<script defer>
        $(function() {
            
            /* *  load the date picker **/
            $('#filter_date_min_id,#filter_date_max_id').datepicker({
                clearBtn: true,
                language: "fr",
                format: "dd-mm-yyyy"
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
        });
</script>