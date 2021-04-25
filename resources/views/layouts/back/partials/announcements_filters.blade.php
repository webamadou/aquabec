<div class="row form-group datatable-filter">
    <div class="col-sm-12 col-md-8 justify-content-start row p-0 bg-light">
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
            <label><small> Catégories :</small></label>
            <select id='filter_categ_id' class="form-control">
                <option value=""> --- </option>
                @foreach($categories as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Type de publication :</small></label>
            <select id='filter_publication_type_id' class="form-control">
                <option value=""> --- e publication--</option>
                <option value="0"> Enregistrée en brouillon </option>
                <option value="1"> Publiée </option>
                <option value="2"> Enregistrée en privé </option>
            </select>
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Code postal :</small></label>
            <input  id='filter_postal_code_id' type="text" name="postal_code" placeholder="Filtrer par code postal" />
        </div>
    </div>
    <div class="col-sm-12 col-md-4 row justify-content-end p-0 bg-light">
        <div class="col-sm-12 col-md-6 px-0">
            <label for="filterdates"><small>Filtrer par publication :</small></label>
            <div class="input-group-filter-min date">
                <input type="text" class="form-control" id="filter_date_min_id"/>
                <!-- <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span> -->
            </div>
        </div>
        <div class="col-sm-12 col-md-6 px-0">
            <label for="filterdates"><small>&nbsp;</small></label>
            <div class="input-group-filter-max date">
                <input type="text" class="form-control" id="filter_date_max_id" />
                <!-- <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span> -->
            </div>
        </div>
    </div>
    <div class="col-12 row mt-1 bg-light p-0">
        <div class="col-sm-12 col-md-2 p-0">
            <label for="price_type" class="col-sm-12 col-md-12"><small>Type de prix :</small> </label>
            <select name="price_type" id="price_type" class="form-control">
                <option value=""> Sélectionez le type de prix </option>
                <option value="1">Entrez le prix</option>
                <option value="3">Gratuit</option>
                <option value="2">Échange</option>
            </select>
        </div>
        <div class="col-sm-12 col-md-3 px-0" id="min-price" style="display: none">
            <label><small>Filtrer par prix minimum :</small></label>
            <input type="number" step="0.01" id='filter_price_min_id' class="form-control" placeholder="Entrer le prix minimum">
        </div>
        <div class="col-sm-12 col-md-3 px-0" id="max-price" style="display: none">
            <label><small>Filtrer par prix maximum:</small></label>
            <input type="number" step="0.01" id='filter_price_max_id' class="form-control" placeholder="Entrer le prix maximum">
        </div>
    </div>
</div>

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
        });
</script>