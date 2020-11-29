@extends('layouts.back.admin')

@section('title','Roles')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.security.roles.index')
                    <h2 class="card-title font-weight-bold">Ajouter un role</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.security.roles.edit')
                    <h2 class="card-title font-weight-bold">Modifier le role</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'admin.settings.security.roles.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.security.roles.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer un nouveau rôle
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des roles</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="roles-table">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Nombre d'utilisateurs</th>
                            <th>Dernière modification</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script>
        $(function() {
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/settings/security/get-role-data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'users_count', name: 'users_count' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var link = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.yes-delete-btn').attr({'href' : link})
            })
        });
    </script>

@endpush
