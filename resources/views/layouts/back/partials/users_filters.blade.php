<form class="col-sm-12 col-md-12 justify-content-center row p-0 bg-light datatable-filter mb-2">
    @hasanyrole('super-admin|admin')
        <div class="col-sm-12 col-md-1 px-0">
            <label><small>N° :</small><a href="#" class="reset-field" data-target="#filter_id">x</a></label>
            <input class="form-control" id='filter_id' type="text" name="id" placeholder="" />
        </div>
    @endrole
    @hasanyrole('super-admin|admin|vendeur|chef-vendeur')
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Prenom :</small><a href="#" class="reset-field" data-target="#filter_prenom">x</a></label>
            <input class="form-control" id='filter_prenom' type="text" name="prenom" placeholder="" />
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Nom :</small><a href="#" class="reset-field" data-target="#filter_name">x</a></label>
            <input class="form-control" id='filter_name' type="text" name="name" placeholder="" />
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Nom utilisateur :</small><a href="#" class="reset-field" data-target="#filter_username">x</a></label>
            <input class="form-control" id='filter_username' type="text" name="username" placeholder="" />
        </div>
        <div class="col-sm-12 col-md-2 px-0">
            <label><small>Email :</small><a href="#" class="reset-field" data-target="#filter_email">x</a></label>
            <input class="form-control" id='filter_email' type="text" name="email" placeholder="" />
        </div>
    @endrole
    @hasanyrole('super-admin|admin')
        <div class="col-sm-12 col-md-2 px-0">
            <label><small> Fonctions :</small><a href="#" class="reset-field" data-target="#filter_roles">x</a></label>
            <select id='filter_roles' class="form-control">
                <option value=""> --- </option>
                @foreach($roles as $key => $value)
                    <option value="{{$value->name}}">{{$value->name}}</option>
                @endforeach
            </select>
        </div>
    @endrole
    @hasanyrole('vendeur|chef-vendeur')
    @endrole
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

            //*** Select the cities of the selected region ***/
            /* const regions = document.getElementById("region_id");
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
            }); */
            
            $('.dt-buttons').append(' - <button class="dt-button buttons-csv buttons-html5 btn btn-success m-0" tabindex="0" aria-controls="announcements-table" type="button" id="reset_filter"><span><i class="fa fa-broom"></i>Effacer les filtres</span></button>')
        });
</script>