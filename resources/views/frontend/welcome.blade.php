@extends('layouts.front.master')

@section('title','Bienvenus')

@section('content')

    @include('frontend.includes.main-hero-slider')

    <section id="tw-features" class="tw-features-area">
        <div class="container">
            <div class="row">
                <div class="col-md-4 wow fadeInLeft" data-wow-duration="1s">
                    <h2 class="column-title text-md-right text-sm-center">A propos de l'Agenda du Québec</h2>
                </div>
                <!-- Col End -->
                <div class="col-md-7 ml-md-auto wow fadeInRight" data-wow-duration="1s">
                    <p class="features-text">{!!@$section_apropos->content!!}</p>
                </div>
                <!-- Col End -->
            </div>
            <!-- End Row 1 -->
            {{--<div class="row">
                <div class="col-lg-4 col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                    <div class="features-box">
                        <div class="features-icon d-table">
                            <div class="features-icon-inner d-table-cell">
                                <img src="images/icon/feature1.png" alt="">
                            </div>
                            <!-- End Features icon inner -->
                        </div>
                        <!-- End Features Icon -->
                        <h3>Titre 1</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquam corporis.</p>
                        <a href="#" class="tw-readmore">Read More
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    <!-- End Single Features -->
                </div>
                <!-- Col End -->
                <div class="col-lg-4 col-md-12  wow fadeInUp" data-wow-duration="1.6s" data-wow-delay=".4s">
                    <div class="features-box">
                        <div class="features-icon d-table">
                            <div class="features-icon-inner d-table-cell">
                                <img src="images/icon/feature2.png" alt="">
                            </div>
                            <!-- End Features Icon inner -->
                        </div>
                        <!-- End Features Icon -->
                        <h3>Titre 2</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquam corporis.</p>
                        <a href="#" class="tw-readmore">Read More
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    <!-- End Single Features -->
                </div>
                <!-- end col -->
                <div class="col-lg-4 col-md-12  wow fadeInUp" data-wow-duration="1.9s" data-wow-delay=".6s">
                    <div class="features-box">
                        <div class="features-icon d-table">
                            <div class="features-icon-inner d-table-cell">
                                <img src="images/icon/feature3.png" alt="">
                            </div>
                            <!-- End Features Icon inner -->
                        </div>
                        <!-- End Features Icon -->
                        <h3>Titre 3</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aliquam corporis.</p>
                        <a href="#" class="tw-readmore">Read More
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    <!-- End Single Features -->
                </div>
                <!-- End col -->
            </div>--}}
            <!-- End Row 2 -->
        </div>
        <!-- End Container -->
    </section>
    <!-- End Subscribtion section -->
    <section id="tw-analysis" class="tw-analysis-area">
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
                    <h2 class="column-title">
                        <span class="text-white">Trouvez tout ici</span>
                    </h2>
                    <div class="analysis-form">
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
                                            <option value="evènement">Evènements</option>
                                            <option value="annonce">Annonces</option>
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
            <div class="row text-center">
                <div class="col section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay=".5s">
                    <h2>
                        <small>Actualités</small>
                        <span>Evénements / Annonces récents</span>
                    </h2>
                    <span class="animate-border border-offwhite ml-auto mr-auto tw-mt-20"></span>
                </div>
                <!-- Col end -->
            </div>
            <!-- Row End -->
            <div class="row wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                @foreach($last_published as $key => $item)
                    @include("frontend.includes.publication_component")
                @endforeach
                <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#" class="btn btn-primary btn-lg tw-mt-80">view all</a></div> -->
            </div>
            <!-- End Row -->
        </div>
        <!-- Container End -->
    </section>
    <!-- End tw blog -->
    <!-- End Analysis Section -->


    <section id="tw-intro" class="tw-intro-area">
        <div class="tw-ellipse-pattern">
            <img src="images/about/about_ellipse.png" alt="">
        </div>
        <!-- End Ellipse Pattern -->
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-12 text-lg-right text-md-center wow fadeInLeft" data-wow-duration="1s">
                    <img src="images/about/about_image.png" alt="" class="img-fluid">
                </div>
                <!-- End Col -->
                <div class="col-lg-5 ml-auto col-md-12 wow fadeInRight" data-wow-duration="1s">
                    <h2 class="column-title">Comment çà marches ?</h2>
                    <span class="animate-border tw-mb-40"></span>
                    {!!@$section_comment->content!!}
                    <!-- End Intro list -->
                    <a href="{{ route('register') }}" class="btn btn-primary">Créer un compte</a>
                    <!-- Default Round Btn -->
                    <a href="{{ route('login') }}" class="btn btn-secondary">Se connecter</a>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Container -->
    </section>
    <!-- Intro section End -->


    <section id="tw-facts" class="tw-facts" style="display: none">
        <div class="facts-bg-pattern d-none d-lg-block">
            <img class="wow fadeInLeft" src="images/funfacts/arrow_left.png" alt="arrwo_left">
            <img class="wow fadeInRight" src="images/funfacts/arrow_right.png" alt="arrow_right">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="tw-facts-box">
                        <div class="facts-img wow zoomIn" data-wow-duration="1s">
                            <img src="images/icon/fact1.png" alt="" class="img-fluid">
                        </div>
                        <!-- End Fatcs image -->
                        <div class="facts-content wow fadeInUp" data-wow-duration="1s">
                            <h4 class="facts-title">Active clients</h4>
                            <span class="counter">200</span>
                            <sup>+</sup>
                        </div>
                        <!-- Facts Content End -->
                    </div>
                    <!-- Facts Box End -->
                </div>
                <!-- Col End -->
                <div class="col-md-3 text-center">
                    <div class="tw-facts-box">
                        <div class="facts-img wow zoomIn">
                            <img src="images/icon/fact2.png" alt="" class="img-fluid">
                        </div>
                        <!-- End Facts Image -->
                        <div class="facts-content wow slideInUp">
                            <h4 class="facts-title">Projects Done</h4>
                            <span class="counter">570</span>
                            <sup>+</sup>
                        </div>
                        <!-- End Facts Content -->
                    </div>
                    <!-- End Facts Box -->
                </div>
                <!-- Col End -->
                <div class="col-md-3 text-center">
                    <div class="tw-facts-box">
                        <div class="facts-img wow zoomIn">
                            <img src="images/icon/fact3.png" alt="" class="img-fluid">
                        </div>
                        <!-- End Facts Image -->
                        <div class="facts-content wow slideInUp">
                            <h4 class="facts-title">Success Rate</h4>
                            <span class="counter">98</span>
                            <sup>%</sup>
                        </div>
                        <!-- End Facts Content -->
                    </div>
                    <!-- End Facts Box -->
                </div>
                <!-- Col End -->
                <div class="col-md-3 text-center">
                    <div class="tw-facts-box">
                        <div class="facts-img wow zoomIn">
                            <img src="images/icon/fact4.png" alt="" class="img-fluid">
                        </div>
                        <!-- End Facts Image -->
                        <div class="facts-content wow slideInUp">
                            <h4 class="facts-title">Awards</h4>
                            <span class="counter">50</span>
                            <sup>+</sup>
                        </div>
                        <!-- End Facts Content -->
                    </div>
                    <!-- End Facts Box -->
                </div>
                <!-- Col End -->
            </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
    </section>
    <!-- Facts End -->

@stop
