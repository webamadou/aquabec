@extends('layouts.back.admin')

@section('title','Catégories ')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.settings.categories.index')
                    <h2 class="card-title font-weight-bold">Ajouter une catégorie</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.settings.categories.edit')
                    <h2 class="card-title font-weight-bold">Modifier la catégorie</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'admin.settings.categories.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.settings.categories.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer une nouvelle catégorie
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Catégories d'évènements</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="event-categories-table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Parent</th>
                            <th>Dernière modification</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Catégories d'annonces</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="announcement-categories-table">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Parent</th>
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
            $('#event-categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/settings/get-event-categories-data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'parent', name: 'parent' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#announcement-categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/settings/get-announcement-categories-data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'parent', name: 'parent' },
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
