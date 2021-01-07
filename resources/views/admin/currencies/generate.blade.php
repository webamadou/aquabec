@extends('layouts.back.admin')

@section('title', 'Générer de la monnaie: '.strtolower(@$currency->name))

@section('content')

    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Liste des permissions</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('banker.currencies.generator')}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="user_id" value="{{@$user->id}}" >
                        <input type="hidden" name="currency_id" value="{{@$currency->id}}" >
                        <div class="row">
                            <div class="col-12 row">
                                <div class="col-6 row">
                                    <label class="label">
                                        <input class="col-sm-2 label__checkbox" value="0" id="currency_type_free" name="currency_type" type="radio" {{ intval(@$_POST['currency_type'] ) === 0 ? 'checked':''}}>
                                        <span class="label__text">
                                            <span class="label__check">
                                                <i class="fa fa-dot-circle icon"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <label for="currency_type_free" style="font-weight: normal;" class="">Credit gratuit</label>
                                </div>
                                <div class="col-6 row">
                                    <label class="label">
                                        <input class="col-sm-2 label__checkbox" value="1" id="currency_type_paid" name="currency_type" type="radio" {{ intval(@$_POST['currency_type'] ) == 1 ? 'checked':''}}>
                                        <span class="label__text">
                                            <span class="label__check">
                                                <i class="fa fa-dot-circle icon"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <label for="currency_type_paid" style="font-weight: normal;" class="">Credit payant</label>
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <label for="amount" class="col-sm-12">Entrez la valeur à transférer *</label>
                                <input type="number" name="amount" id="amount" min="1" class="form-control" value="{{@$_POST['amount']}}" >
                                </select>
                                {!! $errors->first('amount', '<div class="error-message col-12">:message</div>') !!}
                            </div>

                            <div class="col justify-content-end row justify-content-end m-2">
                                <button type="submit" name="save" class="btn btn-lg btn-block btn-primary">
                                <i class="fa fa-plus fa-lg mx-4"></i> Generer
                                </button>
                            </div>
                        </div>
                    </form>
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
                        render: data => { return `${data.value}<br><strong>${data.currency_type}</strong><br>`; }
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
