@extends('layouts.back.admin')

@section('title', 'Générer de la monnaie: '.strtolower(@$currency->name))

@section('content')

    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Générer de la monnaie: {{strtolower(@$currency->name)}}</h2>
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
                                        <input class="col-sm-2 label__checkbox" value="0" id="currency_type_free" name="currency_type" type="radio" >
                                        <span class="label__text">
                                            <span class="label__check">
                                                <i class="fa fa-dot-circle icon"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <label for="currency_type_free" style="font-weight: normal;" class="">Type gratuit</label>
                                </div>
                                <div class="col-6 row">
                                    <label class="label">
                                        <input class="col-sm-2 label__checkbox" value="1" id="currency_type_paid" name="currency_type" type="radio">
                                        <span class="label__text">
                                            <span class="label__check">
                                                <i class="fa fa-dot-circle icon"></i>
                                            </span>
                                        </span>
                                    </label>
                                    <label for="currency_type_paid" style="font-weight: normal;" class="">Type payant</label>
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
                                <i class="fas fa-piggy-bank fa-sm mx-1"></i> GÉNÉRER
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
            $('#credits-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('banker/get-credits-data') }}',
                columns: [
                    { data: 'ref', name: 'ref' },
                    { data: null, name: 'value',
                        render: data => { return `${data.value}<br><strong>${data.currency_type}</strong><br>`; }
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
