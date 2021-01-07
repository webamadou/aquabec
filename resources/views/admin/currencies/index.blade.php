@extends('layouts.back.admin')

@section('title','Liste des monnaies')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'banker.currencies.index')
                        <h2 class="card-title font-weight-bold">Ajouter une monnaie</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.currencies.edit')
                        <h2 class="card-title font-weight-bold">Modifier la monnaie</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'banker.currencies.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('banker.currencies.index') }}">
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
                    <h2 class="card-title font-weight-bold">Liste des monnaies</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="roles-table">
                        <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Nom</th>
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
                ajax: '{{ url('banker/get-currencies-data') }}',
                columns: [
                    /* { data: 'icons', name: 'icons' }, */
                    { data: null, name: 'icons',
                        render: data => { return `<i class="${data.icons} fa-lg text-primary"></i>`; }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>

@endpush