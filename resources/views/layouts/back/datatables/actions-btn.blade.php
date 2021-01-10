<div class="btn-group dropleft">
    <button type="button" class="btn bg-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item text-primary text-bold" href="{{ $edit_route }}">Modifier</a>
        <a href="#" class="dropdown-item text-danger text-bold" data-toggle="modal" data-target="#modal-delete" data-whatever="{{ $delete_route }}">Supprimer</a>
        @if (isset($another_actions))
            <div class="dropdown-divider"></div>
            @foreach($another_actions as $another_action)
                <a class="dropdown-item text-primary text-bold" href="{{ $another_action['route'] }}">{{ $another_action['name'] }}</a>
            @endforeach
        @endif
    </div>
</div>
