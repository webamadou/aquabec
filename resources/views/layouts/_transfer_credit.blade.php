<form method="POST" action="{{route('credits.transfer')}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="send_by" value="{{@$current_user->id}}" >
    <div class="row">
        @php $_POST @endphp
        <div class="col-12 form-group">
            <label for="send_to" class="col-sm-12">Selectionnez le destinataire *</label>
            <select name="send_to" id="" class="form-control">
                <option value="">--- Destinataire ---</option>
                @forelse($users as $key => $value)
                    <option value="{{$key}}" {{@$_POST['send_to'] == $key ? 'selected':''}}>{{$value}}</option>
                @endforeach
            </select>
            <!-- <input class="col-sm-12 col-md-9" name="name" type="text" value=""> -->
            {!! $errors->first('send_to', '<div class="error-message col-12">:message</div>') !!}
        </div>
        @role('banker|super-admin') 
            <div class="col-12 row">
                <div class="col-6 row">
                    <label class="label">
                        <input class="col-sm-2 label__checkbox" value="0" id="credit_type_free" name="credit_type" type="radio" {{ intval(@$_POST['credit_type'] ) === 0 ? 'checked':''}}>
                        <span class="label__text">
                            <span class="label__check">
                                <i class="fa fa-dot-circle icon"></i>
                            </span>
                        </span>
                    </label>
                    <label for="credit_type_free" style="font-weight: normal;" class="">Credit gratuit</label>
                </div>
                <div class="col-6 row">
                    <label class="label">
                        <input class="col-sm-2 label__checkbox" value="1" id="credit_type_paid" name="credit_type" type="radio" {{ intval(@$_POST['credit_type'] ) == 1 ? 'checked':''}}>
                        <span class="label__text">
                            <span class="label__check">
                                <i class="fa fa-dot-circle icon"></i>
                            </span>
                        </span>
                    </label>
                    <label for="credit_type_paid" style="font-weight: normal;" class="">Credit payant</label>
                </div>
            </div>
        @endrole
        <div class="col-12 form-group">
            <label for="sent_value" class="col-sm-12">Entrez la valeur à transférer *</label>
            <input type="number" name="sent_value" id="sent_value" min="1" class="form-control" value="{{@$_POST['sent_value']}}" >
            </select>
            {!! $errors->first('sent_value', '<div class="error-message col-12">:message</div>') !!}
        </div>

        <div class="col justify-content-end row justify-content-end m-2">
            <button type="submit" name="save" class="btn btn-sm btn-block btn-primary">
            <i class="fa fa-save"></i> Enregistrer
            </button>
        </div>
    </div>
</form>