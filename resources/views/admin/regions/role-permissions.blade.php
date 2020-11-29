@extends('layouts.back.admin')

@section('title','Permissions')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="card-title font-weight-bold">Informations</h2>
                </div>
                <div class="card-body">
                    <p>Seules les permissions appartenant au role "<strong>{{ $role->name }}</strong>" sont actifs.</p>
                    <p class="text-info">Vous pouvez mettre à jour la liste des rôles en activant ou en désactivant les permissions avant de cliquer sur le boutton de mise à jour</p>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <form action="{{ route('admin.settings.security.roles.permissions.assign',$role) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="card-header">
                        <h2 class="card-title font-weight-bold">Liste des permissions</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="form-group col-sm-3 col-md-4">
                                    <input type="checkbox" name="permission-{{ $permission->id }}" value="{{ $permission->name }}" id="permission-{{ $permission->id }}" {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                    <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.settings.security.roles.index') }}" class="btn bg-black">Revenir aux roles</a>
                        <button type="submit" class="btn bg-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
