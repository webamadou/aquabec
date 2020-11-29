@extends('layouts.back.admin')

@section('title','Utilisateurs ')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des utilisateurs</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="event-users-table">
                        <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Adresse Email</th>
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
            $('#event-users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('admin/get-users-data') }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'updated_at', name: 'updated_at', width: '150' },
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
