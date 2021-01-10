@extends('layouts.back.admin')

@section('title','Organisations')

@section('content')

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header bg-primary">
                    @if(Route::currentRouteName() == 'admin.organisations.index')
                    <h2 class="card-title font-weight-bold">Ajouter une organisation</h2>
                    @endif
                    @if(Route::currentRouteName() == 'admin.organisations.edit')
                    <h2 class="card-title font-weight-bold">Modifier l'organisation</h2>
                    @endif
                </div>
                <div class="card-body">
                    {!! form($form) !!}
                </div>
                @if(Route::currentRouteName() == 'admin.organisations.edit')
                    <div class="card-footer">
                        <a class="btn btn-link float-right text-dark font-weight-bold" href="{{ route('admin.organisations.index') }}">
                            <i class="mr-2 fa fa-plus"></i>
                            Créer une nouvelle organisation
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des organisations</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="event-organisations-table">
                        <thead>
                        <tr>
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
            $('#event-organisations-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/get-organisations-data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'updated_at', name: 'updated_at', width: '100' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '80' }
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
