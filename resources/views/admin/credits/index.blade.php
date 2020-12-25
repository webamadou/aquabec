@extends('layouts.back.admin')

@section('title','Packs de credit')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.security.permissions.index')
                        <h2 class="card-title font-weight-bold">Ajouter une permission</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.security.permissions.edit')
                        <h2 class="card-title font-weight-bold">Modifier la permission</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'admin.settings.security.permissions.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.security.permissions.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer une nouvelle permission
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des permissions</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="credits-table">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Valeur</th>
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
            $('#credits-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('banker/get-credits-data') }}',
                columns: [
                    { data: 'ref', name: 'ref' },
                    /* { data: 'value', name: 'value' }, */
                    { data: null, name: 'value',
                        render: data => { return `${data.value}<br><strong>${data.credit_type}</strong><br>`; }
                    },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[ 2, 'desc' ]],
                pageLength: 100,
            });
        });
    </script>

@endpush
