@extends('layouts.front.master')

@section('title','Bienvenus')

@section('content')

    <!-- End Subscribtion section -->
    <section id="tw-analysis" class="tw-analysis-area p-0">
        <div class="analysis-bg-pattern d-none d-md-inline-block">
            <img class="wow fadeInUp" src="images/check-seo/cloud.png" alt="">
            <img class="wow fadeInUp" src="images/check-seo/cloud2.png" alt="">
            <img class="wow fadeInUp" src="images/check-seo/announce.png" alt="">
            <img class="wow fadeInUp" src="images/check-seo/chart.png" alt="">
        </div>
        <!-- End Analysis Pattern img -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center wow fadeInDown">
                    <!-- <h2 class="column-title"> <span class="text-white">Trouvez tout ici</span> </h2> -->
                    <div class="analysis-form m-0">
                        <form class="form-vertical" action="{{route('search')}}">
                            <div class="row justify-content-center">
                                <div class="col-lg-4 col-md-12 no-padding">
                                    <div class="form-group tw-form-round-shape">
                                        <input type="text" id="search_q" name="search_q" placeholder="Que cherchez vous ?" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 no-padding">
                                    <div class="form-group tw-form-round-shape">
                                        <select id="content_type" name="content_type" placeholder="Où ?" class="form-control">
                                            <option value="evènement" {{old('content_type',@$content_type) == 'evènement'?'selected':''}}>Evènements</option>
                                            <option value="annonce" {{old('content_type',@$content_type) == 'annonce'?'selected':''}}>Annonces</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 no-padding">
                                    <div class="form-group">
                                        <input type="submit" value="Recherche">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                    <!-- End Analysis form -->
                </div>
                <!-- Col End -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End container -->
    </section>

    <section id="tw-blog" class="tw-blog">
        <div class="container">
            <!-- Row End -->
            <div class="row wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                @forelse(@$response as $key => $item)
                    @include("frontend.includes.publication_component")
                @empty
                    <h1 class="text-center" style="color: #d2d2d1">Nous n'avons rien trouvé correspondant à votre recherche.</h1>
                @endforelse
                <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#" class="btn btn-primary btn-lg tw-mt-80">view all</a></div> -->
            </div>
            <div id="items-pagination">{{ $response->links() }}</div>
            <!-- End Row -->
        </div>
        <!-- Container End -->
    </section>

    <!-- Facts End -->

@stop
