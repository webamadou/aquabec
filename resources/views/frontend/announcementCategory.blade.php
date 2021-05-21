@extends('layouts.front.master')

@section('title','Bienvenus')

@section('content')
    <section id="tw-blog" class="tw-blog">
        <div class="container">
            <div class="row text-center">
                <div class="col section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay=".5s">
                    <h2>
                        <small>Annonce </small>
                        <span>Catégorie / {{@$category->name}}</span>
                    </h2>
                    <span class="animate-border border-offwhite ml-auto mr-auto tw-mt-20"></span>
                </div>
                <!-- Col end -->
            </div>
            <!-- Row End -->
            <div class="row fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                <div class="col-md-3 d-sm-none d-md-block filter-side-bar">
                    <form action="" class="row" id="filter_form_announcement" class="filter_form">
                        <div class="col-12 text-center text-lg-center text-info" id="filter-loading" style="display:none"><i class="fa fa-spin fa-spinner"></i></div>
                        <input name="categ_id" id="categ_id" class="form-control" type="hidden" value="{{ $category->slug }}">
                        <div class="col-sm-12">
                            <label for="region_id">Régions</label>
                            <select name="region_id" id="region_id" class="form-control">
                                <option value=""> --- </option>
                                @foreach($regions as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="city_id">Villes</label>
                            <select name="city_id" id="city_id" class="form-control">
                                <option value=""> --- </option>
                                @foreach($cities as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="postal_code_id">Code postal</label>
                            <input name="postal_code_id" id="postal_code_id" class="form-control" >
                        </div>
                        <div class="col-sm-12">
                            <label for="price_id">Prix</label>
                            <input name="price_id" id="price_id" class="form-control" >
                        </div>
                        <!-- <div class="col-sm-12">
                            <label for="dates_id">Dates</label>
                            <input name="dates_id" id="dates_id" class="form-control" >
                        </div> -->
                        <div class="col-sm-12">
                            <label for="annonceur_filter">Annonceur</label>
                            <input name="autocomplete_user" id="annonceur_filter" class="form-control select-members" >
                            <input name="user_id" id="user_id" type="hidden">
                            <ul id="autocompletes" style="display: none;"></ul> 
                        </div>
                        <div class="col-sm-12 mt-2">
                            <button type="reset" id="delete-filters" class="btn btn-sm btn-primary"><i class="fa fa-broom"></i> Effacer les filtres</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-md-9 row" id="list-component-wrapper">
                    @forelse(@$announcements as $key => $item)
                        @include("frontend.includes.publication_component2")
                    @empty
                </div>
                    <h1 class="text-center" style="color: #d2d2d1">Aucune annonce n'est enregistré dans cette catégorie</h1>
                @endforelse
                <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#" class="btn btn-primary btn-lg tw-mt-80">view all</a></div> -->
            </div>
            <div id="items-pagination">{{ $announcements->links() }}</div>
            <!-- End Row -->
        </div>
        <!-- Container End -->
    </section>
    <!-- template tag -->

    <template>
        <div class="mozaique-item visible col-sm-6 col-md-4">
            <div class="card shadow-sm p-0">
                <a id="item_img" href=""></a>
                <div class="card-body p-0">
                    <p class="card-text" id="item_title">
                        <a href=""></a>
                    </p>
                    <div class="d-block" style="background: #dcdcdc; padding: 0;">
                        <div type="button" class="px-1" id="item_price"></div>
                        <div type="button" class="px-1" id="item_category"></div>
                        <div type="button" class="px-1" id="item_author"></div>
                    </div>
                </div>
            </div>
        </div>
    </template>
@stop

@push('scripts')
<script>
</script>
@endpush
