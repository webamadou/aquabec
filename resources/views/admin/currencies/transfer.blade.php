@extends('layouts.back.admin')

@section('title','Transfert de monnaies')

@section('content')

    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Transfert d'un monnaie</h2>
                </div>
                <div class="card-body">
                    @include('layouts._transfer_credit')
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
                dom: 'Bfrliptip',
                buttons: [
                    'csv', 'excel', 'pdf'
                ],
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
