@extends('layouts.back.user')

@section('title','Nouvel évènement')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Ajout d'un événement (Le montage)</h2>
                    <div class="card-tools">
                        <a href="{{ route('user.events.index') }}" class="btn btn-primary btn-sm">
                            <i class="mr-2 fa fa-list"></i>
                            Liste d'événements
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    {!! form_start($form) !!}
                    <div class="row">
                        <div class="col-sm-8">

                            {!! form_row($form->title) !!}

                            <div class="row">
                                <div class="col-sm-6">
                                    {!! form_row($form->category_id) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! form_row($form->organisation_id) !!}
                                </div>
                            </div>

                            {!! form_row($form->description) !!}

                            <div class="row">
                                <div class="col-sm-6">
                                    {!! form_row($form->region_id) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! form_row($form->city_id) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    {!! form_row($form->email) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! form_row($form->telephone) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    {!! form_row($form->postal_code) !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! form_row($form->website) !!}
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <img id="img-preview" src="https://via.placeholder.com/600x350?text=Image+Preview" alt="your image" style="max-height: 200px" class="img-fluid"/>
                            </div>
                            <div class="form-group">
                                {!! form_label($form->image) !!}
                                <div class="custom-file">
                                    {!! form_widget($form->image) !!}
                                    <label class="custom-file-label" for="customFile">Charger une image</label>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! form_label($form->dates) !!}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    {!! form_widget($form->dates) !!}
                                </div>
                                <!-- /.input group -->
                            </div>
                            {!! form_rest($form) !!}
                        </div>
                    </div>
                    {!! form_end($form) !!}
                </div>
            </div>
        </div>
    </div>

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-preview')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function showCity(region_id) {
            var xhttp;
            if (region_id == "") {
                document.getElementById("city_id").innerHTML = "";
                return;
            }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //document.getElementById("city_id").innerHTML = this.responseText;
                    console.log(this.responseText)
                }
            };
            xhttp.open("GET", "{{ url('get-city-by-region') }}/"+region_id, true);
            xhttp.send();
        }
    </script>

    {{--<script>
        $(function() {
            $('#event-categories-table').DataTable({
                processing: true,
                serverSide: true,
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
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
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
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
    </script>--}}

@endpush
