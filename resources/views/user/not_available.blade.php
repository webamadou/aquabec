@extends('layouts.front.app')

@section('title','contenu introuvable')

@section('content')
    <section class="ftco-about ftco-section ftco-no-pt ftco-no-pb" id="about-section">
        <div class="container">
            <div class="row d-flex no-gutters">
                <div class="col-md-12 col-lg-12 pl-md-12 pl-lg-12 py-5">
                    <div class="py-md-1">
                        <div class="row justify-content-start pb-3">
                            <h2 class="col-12 text-danger bg-gray text-center"><i class="fa fa-exclamation"></i> Ce contenu n'est pas disponible </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.back.alerts.delete-confirmation')

@stop

@push('scripts')

    <script>
        $(function() {
        });
    </script>

@endpush