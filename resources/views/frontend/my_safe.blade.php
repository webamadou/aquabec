@extends('layouts.front.master')

@section('title','Mon Coffre')

@section('content')

@inject('credit', 'App\Models\Credit')
<section id="tw-contact-us" class="tw-contact-us bg-offwhite">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section-heading text-center">
                    <h2>
                        <small>Vos montants sur chaque monnaie</small>
                        <!--  <span>l'agenda.quebec</span> -->
                    </h2>
                </div>
            </div>
            <!-- Col End -->
        </div>
        <!-- Row End -->
        <div class="contact-us-form row justify-content-between">
            @foreach($user->currencies as $currency)
                @if(@$currency->pivot->free_currency > 0 || @$currency->pivot->paid_currency)
                <div class="col-md-6 col-lg-4 col-sm-12 text-center mb-5">
                    <div class="tw-facts-box">
                        <div class="facts-img wow zoomIn" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: zoomIn;">
                            <h2 class="info-box-icon"><i class="{{$currency->icons}}"></i></h2>
                            <h2 class="text-danger">{{$currency->name}}</h2>
                            <p>{{$currency->description}}</p>
                        </div>
                        <!-- End Fatcs image -->
                        <div class="facts-content wow fadeInUp" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
                            <p>
                                <strong class="facts-title">Valeur Gratuite</strong>
                                <span class="badge bg-warning rounded-pill" style="font-size: 1.4rem">{{$credit->formatCredit(@$currency->pivot->free_currency ?: 0)}}</span>
                            </p>
                            <p>
                                <strong class="facts-title">Valeur payante</strong>
                                <span class="badge bg-warning rounded-pill" style="font-size: 1.4rem">{{$credit->formatCredit(@$currency->pivot->paid_currency ?: 0)}}</span>
                            </p>
                        </div>
                        <!-- Facts Content End -->
                    </div>
                    <!-- Facts Box End -->
                </div>
                @endif
            @endforeach
        </div>
    </form>
    <!-- Form end -->
</div>
<!-- Contact us form end -->
</div>
<!-- Container End -->
</section>
<!-- Contact End -->

@stop
