@extends('layouts.back.admin')

@section('title','Packs de credits')

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-hand-holding-heart"></i></span>
                <div class="info-box-content">
                    <strong class="info-box-text">Credit Gratuit</strong>
                    <h3 class="info-box-number">{{ $free_credits}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-hand-holding-usd"></i></span>
                <div class="info-box-content">
                    <strong class="info-box-text">Credit Payant</strong>
                    <h3 class="info-box-number">{{ $paid_credits }}</h3>
                </div>
            </div>
        </div>
    </div>
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
            <div class="row">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#transferCredits"> Transférer du credit </button>
            </div>
            <div class="modal fade" id="transferCredits" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @include('layouts._transfer_credit')
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
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
            $('#send_to').typeahead({
                source: function(query, process) {
                    var $url = "{{ route('get-users-list') }}" ;
                    var $items = new Array;
                    $items = [""];
                    $.ajax({
                        url: $url,
                        dataType: "json",
                        type: "GET",
                        success: function(data) {
                            console.log(data);
                            $.map(data, function(data){
                                var group;
                                group = {
                                    id: data.id,
                                    name: data.name,                            
                                    toString: function () {
                                        return JSON.stringify(this);
                                        //return this.app;
                                    },
                                    toLowerCase: function () {
                                        return this.name.toLowerCase();
                                    },
                                    indexOf: function (string) {
                                        return String.prototype.indexOf.apply(this.name, arguments);
                                    },
                                    replace: function (string) {
                                        var value = '';
                                        value +=  this.name;
                                        if(typeof(this.level) != 'undefined') {
                                            value += ' <span class="pull-right muted">';
                                            value += this.level;
                                            value += '</span>';
                                        }
                                        return String.prototype.replace.apply('<div style="padding: 10px; font-size: 1.5em;">' + value + '</div>', arguments);
                                    }
                                };
                                $items.push(group);
                            });
                            process($items);
                        }
                    });
                },
                property: 'name',
                items: 10,
                minLength: 2,
                updater: function (item) {
                    var item = JSON.parse(item);
                    console.log(item.name); 
                    $('#hiddenID').val(item.id);       
                    return item.name;
                }
            });



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

            //Autocompletion to check the user to transfer credit
            var path = "{{ route('get-users-list') }}";
            /* $('input#send_to').typeahead({
                source:  function (query, process) {
                    return $.get(path, { query: query }, function (data) {
                        //console.log(data[0].name);
                        return process(data);
                    });
                }
            }); */
        });


        $(document).ready(function() {
            
        });
    </script>

@endpush
