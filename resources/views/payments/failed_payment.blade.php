@extends('layouts.transaction')

<!-- @ section('title','Informations personelles') -->

@section('content')
<div class="card mx-auto w-50">
    <div class="col-12">
        <h1 class="text-red mt-2"><i class="fa fa-exclamation-triangle"></i> </h1>
    </div>
    <div class="card-body" style="font-size: 1.8rem">
        <h1>Il s'est produit une erreur lors de la transaction</h1>
        {!!$errors!!}
    </div>
</div>
@endsection