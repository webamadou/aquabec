@extends('layouts.front.app')

@section('title','')

@inject('credit', 'App\Models\Credit')
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title font-weight-bold">Tranférer de <span class="badge badge-primary">{{@$currency->name}}</span></h2>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-primary"><i class="{{@$currency->icons}}"></i></span>
                    <div class="info-box-content">
                        <h3>{{$currency->name}}</h3>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Valeur Gratuite
                                <span class="badge bg-primary rounded-pill">{{ $credit->formatCredit(@$currency->pivot->free_currency ?: 0) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Valeur payante
                                <span class="badge bg-primary rounded-pill">{{ $credit->formatCredit(@$currency->pivot->paid_currency ?: 0)}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('credits.transfer')}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="send_by" value="{{@$current_user->id}}" >
                        <input type="hidden" name="currency_id" value="{{@$currency->id}}" >
                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="send_to" class="col-sm-12">Selectionnez le destinataire *</label>
                                <select name="send_to" id="" class="form-control">
                                    <option value="">--- Destinataire ---</option>
                                    @forelse($users as $key => $user)
                                        <option value="{{$user->id}}" {{old("send_to") == $user->id ? 'selected':''}}>
                                        {{ucfirst($user->username)}}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- <div class="col-sm-12">
                                    <label for="annonceur_filter">Annonceur</label>
                                    <input name="autocomplete_user" id="annonceur_filter" class="form-control select-members" >
                                    <input name="send_to" id="user_id" type="hidden">
                                    <ul id="autocompletes" style="display: none;"></ul> 
                                </div> -->
                                <!-- <input class="col-sm-12 col-md-9" name="name" type="text" value=""> -->
                                {!! $errors->first('send_to', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            @role('banker|super-admin|admin') 
                                <div class="col-12 row">
                                    <label for="credit_type" class="col-sm-12 col-md-12">Type de monnaie à envoyer : </label>
                                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                        <input type="radio" class="btn-check" name="credit_type" id="credit_type_free" autocomplete="off" value="0" {{ intval(old("credit_type") === 0 ) ? "checked":"" }}>
                                        <label class="btn btn-outline-primary" for="credit_type_free"><i class="fa fa-hand-holding-heart"></i><br> Type gratuit </label>

                                        <input type="radio" class="btn-check" name="credit_type" id="credit_type_paid" autocomplete="off" value="1" {{ intval($user->credit_type === 1 ) ? 'checked':"" }}>
                                        <label class="btn btn-outline-primary" for="credit_type_paid"><i class="fa fa-dollar-sign"></i><br> Type payant</label>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="credit_type" value="0" />
                            @endrole
                            <div class="col-12 form-group">
                                <label for="sent_value" class="col-sm-12">Entrez la valeur à transférer *</label>
                                <input type="number" name="sent_value" id="sent_value" min="1" class="form-control" value="{{@$_POST['sent_value']}}" >
                                </select>
                                {!! $errors->first('sent_value', '<div class="error-message col-12">:message</div>') !!}
                            </div>
                            <div class="col-12 form-group">
                                <label for="notes" class="col-sm-12">Ajouter une note (facultatif)</label>
                                <textarea name="notes" id="notes" cols="30" rows="5" placeholder="Ajouter une note" class="ckeditor form-control">{{old("notes")}}</textarea>
                                </select>
                                {!! $errors->first('notes', '<div class="error-message col-12">:message</div>') !!}
                            </div>

                            <div class="col justify-content-end row justify-content-end m-2">
                                <button type="submit" name="save" class="btn btn-sm btn-block btn-primary">
                                <i class="fa fa-share-square"></i> Envoyer
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

    <script type="text/javascript">
        $(document).ready(function () {
            const autocomplete_field = document.querySelector('input[name="autocomplete_user"]');
            const autocompletes = document.getElementById("autocompletes");
            const user_id_field = document.getElementById("user_id");
            if (autocomplete_field !== null) {
                autocomplete_field.addEventListener('keyup', function (e) {
                    $.ajax({
                        url: `${SITE_URL}/autocomplete-user`,
                        type: "get",
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "autocomplete_user": autocomplete_field.value,
                        },
                        beforeSend: function () {
                            console.log('loading users');
                        }
                    }).done(function (data) {
                        console.log(data);
                        let list = '';
                        for (let item in data) {
                            const user = data[item];
                            list += `<li data-user="${user.username}" class="select-user">${user.username}</li>`;
                        }
                        autocompletes.innerHTML = `<div class="close-autocomplete">x</div> ${list}`;
                        autocompletes.style.display = "block";

                    }).fail(function (jqXHR, ajaxOptions, thrownError) {
                        console.log('No response from server');
                    });
                });
                //When click to close the autocomplete
                /* document.querySelector(".close-autocomplete")[0] */
                /* autocomplete_field.addEventListener('focusout', function(e){
                    autocompletes.style.display = "none";
                }); */
                const close_autocomplete = document.querySelector(".close-autocomplete");
                $('body').on('click', '.close-autocomplete', function (e) {
                    autocompletes.style.display = "none";
                });

                //when clicking on one of the result on the autocompletion
                $('body').on('click', '.select-user', function (e) {
                    const username = $(this).data("user");
                    autocomplete_field.value = username;

                    if (user_id_field != null) {
                        user_id_field.value = username;
                        if (document.getElementById('filter_form_announcement') != null)
                            filter_elements();//we execute filter announcements function in case we need to filter
                        if (document.getElementById('filter_form_events') != null)
                            filter_events();//we execute filter events function in case we need to filter
                    }
                    autocompletes.style.display = "none";
                });
            }
        })
    </script>

@endpush