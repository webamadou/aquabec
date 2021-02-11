<div class="btn-group dropleft">
    <button type="button" class="btn bg-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item text-primary text-bold" href="{{ $edit_route }}"><i class="fa fa-user-edit"></i> Modifier</a>
        @if(isset($delete_route))
            <a href="#" class="dropdown-item text-danger text-bold" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ $delete_route }}"><i class="fa fa-user-times"></i> Supprimer</a>
        @endif
        @if (isset($another_actions))
            <div class="dropdown-divider"></div>
            @foreach($another_actions as $another_action)
                <a class="dropdown-item text-primary text-bold" href="{{ $another_action['route'] }}">{{ $another_action['name'] }}</a>
            @endforeach
        @endif
    </div>
</div>
