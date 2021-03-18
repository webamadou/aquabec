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
            <div class="row wow fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                @forelse(@$announcements as $key => $item)
                    @include("frontend.includes.publication_component")
                @empty
                    <h1 class="text-center" style="color: #d2d2d1">Aucune annonce n'est enregistré dans cette catégorie</h1>
                @endforelse
                <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#" class="btn btn-primary btn-lg tw-mt-80">view all</a></div> -->
            </div>
            <div id="items-pagination">{{ $announcements->links() }}</div>
            <!-- End Row -->
        </div>
        <!-- Container End -->
    </section>

@stop
