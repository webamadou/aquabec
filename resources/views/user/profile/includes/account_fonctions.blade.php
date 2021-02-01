 <div class="row">
    <h2>Fonctions</h2>
    <div class="bg-white col-md-3 col-sm-6 justify-content-evenly row py-4">
        <div class="accordion" id="accordionFlushExample">
        @foreach($fonctions as $fonction)
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading{{$fonction->id}}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$fonction->id}}" aria-expanded="false" aria-controls="flush-collapse{{$fonction->id}}"><i class="nav-icon fa fa-user-tag"></i>&nbsp; {{ucfirst($fonction->name)}} </button>
                </h2>
                <div id="flush-collapse{{$fonction->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$fonction->id}}" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        {{$fonction->description}}
                        @hasanyrole($fonction->name)
                            <div class="col-12 row aq-card-action">
                                <a href="#" class="btn btn-success btn-sm">Vouse êtes déjà {{strtolower($fonction->name)}}</a>
                            </div>
                        @else
                            <hr size="60%" class="mx-auto">
                            <div class="col-12 row aq-card-action" id="{{$fonction->id}}">
                                <a href="#" class="btn btn-primary btn-sm subscribe_role" data-role_id="{{$fonction->id}}" data-role_description="{{$fonction->description}}" data-role_name="{{$fonction->name}}"><i class="fa fa-plus"></i> S'inscrire à cette fonction</a>
                            </div>
                        @endrole
                    </div>
                </div>
            </div>
        @endforeach  
        </div>
    </div>

    <div class="bg-white col-md-8 col-sm-6 justify-content-evenly row">
        @foreach($user->roles as $role)
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <h3 class="py-0 pt-4 text-center">{{ucfirst($role->name)}}</h3>
                        <h4 class='badge badge-warning mx-auto'><i class='fa fa-coins'></i> Monnaie utilisée : {{$role->currency->name}}</h4>
                        {!! $role->free_events ? "<span class='badge badge-success mx-auto'><i class='fa fa-dot-circle'></i> Activités gratuites</span>":'' !!} 
                        {!! $role->free_annoncements ? "<span class='badge badge-success mx-auto'><i class='fa fa-dot-circle'></i> Annonces gratuites</span>":'' !!}
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <hr size="100%" class="mx-auto">
                            <!-- <strong class="card-title">Card title</strong> -->
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong class="card-text">{{ucfirst($role->currency->name)}} par événement : {{intval(- $role->events_price)}} </strong>
                            </li>
                            <li class="list-group-item">
                                <strong class="card-text">{{ucfirst($role->currency->name)}} par annonce : {{intval(- $role->annoucements_price)}} </strong>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Full screen modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="{{route('user.assign_role')}}" method="post">
            @csrf
            <div class="modal-header">
                <h2 class="modal-title text-center" id="exampleModalLabel">Vous allez vous inscrire a la fonction <span id="role_name"></span></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="role_id" id="form_role_id">
                    <input type="hidden" name="user_id" id="form_user_id">
                <div class="mb-3"> Confirmer votre inscription à la fonction <span id="confirm_role_name"></span></div>
                <div class="mb-3"><span id="confirm_role_description"></span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Confimer</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script defer>
$(function(){
    const btn = $("#toggle__modal");
    $('.subscribe_role').on('click',function(ev){
        ev.preventDefault();
        const role_id   = $(this).data('role_id');
        const role_name = $(this).data('role_name');
        const role_desc = $(this).data('role_description');

        $("#role_name").text(role_name);
        $("#form_role_id").val(role_id);
        $("#form_user_id").val({{$user->id}});
        const myModal = new bootstrap.Modal(document.getElementById('myModal'))
        //alert("This here is a test");
        myModal.show();
    });
});
</script>