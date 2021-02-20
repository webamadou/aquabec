@extends('layouts.transaction')

<!-- @ section('title','Informations personelles') -->

@section('content')
<div class="card mx-auto w-50">
    <div class="col-12" style="font-size: 1.8rem">
        <h1 class="text-green mt-2"><i class="fa fa-check-circle"></i> </h1>
    </div>
    <div class="card-body" style="font-size: 1.8rem">
        {!!$message!!}
    </div>
</div>
@endsection