@extends('layouts.front.master')

@section('title','Contactez Nous')

@section('content')

<section id="tw-contact-us" class="tw-contact-us bg-offwhite">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section-heading text-center">
                    <h2>
                        <small>Veuillez confirmer votre abonnement</small>
                        <!--  <span>l'agenda.quebec</span> -->
                    </h2>
                </div>
            </div>
            <!-- Col End -->
        </div>
        <!-- Row End -->
        <div class="contact-us-form">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show"  role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('success') }}
            </div>
            @endif
            <form class="contact-form" action="{{ route('contact.post') }}" method="POST">
                @csrf
                <div class="error-container"></div>
                <div class="row">
                    <!-- Col end -->
                    <!-- <div class="col-lg-4 offset-lg-3 col-md-12 m-0"> -->
                    <div class="col-12 row justify-content-center">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h3 class="text-center">Vous avez optez pour la formule {{$subs->title}}</h3>
                                <span class="animate-border border-ash ml-auto mr-auto tw-mt-20 tw-mb-40"></span>
                            </div>
                        </div>
                        <div class="col-lg-4 offset-lg-4 col-md-12 m-0">
                            <div class="tw-latest-post">
                                <div class="subscribtions text-center" style="border-bottom: 5px solid #f86541">
                                    <h3 class="post-title "><a href="#">-</a></h3>
                                </div>
                                <!-- End Latest Post Media -->
                                <div class="post-body p-0">
                                   <div class="flex-1 bg-white text-gray-600 rounded-t rounded-b-none overflow-hidden shadow">
                                       <ul class="w-full text-center text-sm subs-options">
                                           <li class="border-b py-4"><strong>Credit :</strong> {{$subs->credit}}</li>
                                           <li class="border-b py-4"><strong>Quota : </strong>{{$subs->quota}}</li>
                                       </ul>
                                   </div>
                                   <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                                       <div class="w-full pt-6 text-3xl text-gray-600 font-bold uk-text-center subs-prices">
                                           {{$subs->price}} <span class="text-base"> CAD<!-- for one user --></span>
                                       </div>
                                       <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s">
                                           <a href="{{route("subscription_summary", $subs->id)}}" class="btn btn-primary btn-lg tw-mt-80">Souscrire</a>
                                       </div> -->
                                   </div>
                                <!-- End Post info -->
                                </div>
                           <!-- End Post Body -->
                            </div>
                        </div>
                    <!-- End Tw Latest Post -->
                    </div>
                <!-- Col 12 end -->
                </div>
           <!-- Form row end -->
           <div class="text-center">
            <button class="btn btn-primary tw-mt-30" type="submit">Confirmer</button>
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
