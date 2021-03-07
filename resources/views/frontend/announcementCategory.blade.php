@extends('layouts.front.master')

@section('title','Bienvenus')

@section('content')

    <section id="tw-blog" class="tw-blog">
        <div class="container">
            <div class="row text-center">
                <div class="col section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay=".5s">
                    <h2>
                        <small>Annonce</small>
                        <span>Catégorie / {{@$category->name}}</span>
                    </h2>
                    <span class="animate-border border-offwhite ml-auto mr-auto tw-mt-20"></span>
                </div>
                <!-- Col end -->
            </div>
            <!-- Row End -->
            <div class="row wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                @forelse(@$announcements as $key => $announcement)
                    <div class="col-lg-4 col-md-12">
                        <div class="tw-latest-post">
                            <div class="latest-post-media text-center">
                            <a href="{{route('page_announcement',@$announcement->slug)}}"><img src="{{ route('show.image',@$announcement->images) }}" alt="{{@$announcement->title}}"></a>
                            </div>
                            <!-- End Latest Post Media -->
                            <div class="post-body">
                                <div class="post-item-date">
                                    <div class="post-date {{class_basename(@$announcement) === 'Event'? 'event':''}}">
                                        <span class="date">{{date('d', strtotime(@$announcement->published_at))}}</span>
                                        <span class="month">{{@$month_array[intval(date('m', strtotime(@$announcement->published_at)))] }}</span>
                                    </div>
                                </div>
                                <!-- End Post Item Date -->
                                <div class="post-info">
                                    <div class="post-meta">
                                        <span class="post-author">
                                            Posté par <a href="{{route('user.show_profile',@$announcement->owned->id)}}">{{@$announcement->owned->prenom}} {{@$announcement->owned->name}}</a>
                                        </span>
                                    </div>
                                    <!-- End Post Meta -->
                                    <h3 class="post-title"><a href="{{route('page_announcement',@$announcement->slug)}}">{{@$announcement->title}}</a></h3>
                                    <div class="entry-content">
                                        <p>
                                            {!! substr(@$announcement->description, 0, 90); !!}...
                                        </p>
                                    </div>
                                    <div class="post-emplacements-meta">
                                        <div class="post-emplacements">
                                            <span class="city">Ville : {{@$announcement->region->name}}</span><br>
                                            <span class="redion">Region : {{@$announcement->city->name}}</span>
                                        </div>
                                    </div>
                                    <!-- End Entry Content -->
                                </div>
                                <!-- End Post info -->
                            </div>
                            <!-- End Post Body -->
                        </div>
                        <!-- End Tw Latest Post -->
                    </div>
                @empty
                    <h1 class="text-center" style="color: #d2d2d1">Aucune annonce n'est enregistré dans cette catégorie</h1>
                @endforelse
                <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#" class="btn btn-primary btn-lg tw-mt-80">view all</a></div> -->
            </div>
            <!-- End Row -->
        </div>
        <!-- Container End -->
    </section>

@stop
