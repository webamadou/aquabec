@extends('layouts.front.master')

@section('title','Bienvenus')

@section('content')

    <section id="tw-blog" class="tw-blog">
        <div class="container">
            <div class="row text-center">
                <div class="col section-heading wow fadeInDown" data-wow-duration="1s" data-wow-delay=".5s">
                    <h2>
                        <small>Evénements</small>
                        <span>{{$region->name}}</span>
                    </h2>
                    <span class="animate-border border-offwhite ml-auto mr-auto tw-mt-20"></span>
                </div>
                <!-- Col end -->
            </div>
            <!-- Row End -->
            <div class="row wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                @forelse($events as $key => $event)
                    <div class="col-lg-4 col-md-12">
                        <div class="tw-latest-post">
                            <div class="latest-post-media text-center">
                                <img src="{{ route('show.image',$event->images) }}" alt="{{$event->title}}">
                            </div>
                            <!-- End Latest Post Media -->
                            <div class="post-body">
                                <div class="post-item-date">
                                    <div class="post-date {{class_basename($event) === 'Event'? 'event':''}}">
                                        <span class="date">{{date('d', strtotime($event->published_at))}}</span>
                                        <span class="month">{{@$month_array[intval(date('m', strtotime($event->published_at)))] }}</span>
                                    </div>
                                </div>
                                <!-- End Post Item Date -->
                                <div class="post-info">
                                    <div class="post-meta">
                                        <span class="post-author">
                                            Posté par <a href="{{route('user.show_profile',$event->owned->id)}}">Admin</a>
                                        </span>
                                    </div>
                                    <!-- End Post Meta -->
                                    <h3 class="post-title">
                                        <a href="{{route('page_event',$event->slug)}}">{{$event->title}}</a>
                                    </h3>
                                    <div class="post-emplacements-meta">
                                        <div class="post-emplacements">
                                            <span class="redion">{{@$event->city->name}}</span>
                                            <span class="city">{{@$event->region->name}}</span>
                                        </div>
                                    </div>
                                    <!-- End Entry Content -->
                                </div>
                                <!-- End Post info -->
                            </div>
                            <!-- End Post Body -->
                        </div>
                        <div class="col-sm-12">
                            <label for="postal_code_id">Code postal</label>
                            <input name="postal_code_id" id="postal_code_id" class="form-control" >
                        </div>
                        <div class="col-sm-12">
                            <label for="dates_id">Dates</label>
                            <input name="dates_id" id="dates_id" class="form-control" >
                        </div>
                        <div class="col-sm-12">
                            <label for="categ_id">Catégories</label>
                            <select name="categ_id" id="categ_id" class="form-control">
                                <option value=""> --- </option>
                                @foreach($categories as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="annonceur_filter">Annonceur</label>
                            <input name="autocomplete_user" id="annonceur_filter" class="form-control select-members" >
                            <input name="user_id" id="user_id" type="hidden">
                            <ul id="autocompletes" style="display: none;"></ul> 
                        </div>
                        <div class="col-sm-12 mt-2">
                            <button type="reset" id="delete-events-filters" class="btn btn-sm btn-primary"><i class="fa fa-broom"></i> Effacer les filtres</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-md-9 row" id="list-component-wrapper">
                    @forelse($events as $key => $item)
                        @include("frontend.includes.publication_component2")
                    @empty
                </div>
                    <h1 class="text-center" style="color: #d2d2d1">Aucun évènement n'est enregistré dans cette region</h1>
                @endforelse
                <!-- <div class="col-md-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="1s"><a href="#" class="btn btn-primary btn-lg tw-mt-80">view all</a></div> -->
            </div>
            <div id="items-pagination">{{ $events->links() }}</div>
            <!-- End Row -->
        </div>
        <!-- Container End -->
    </section>

@stop

@push('scripts')
<script defer>
        $(function() {
            //*** Select the cities of the selected region ***
            const regions = document.getElementById("region_id");
            document.getElementById("filter_region_id").addEventListener('change', function (event) {
                const selected_region = this.value;
                $.ajax({
                    type: 'get',
                    url: `{{url('/select_cities')}}`,
                    data: {'id': selected_region},
                    success: function(res){
                        const entries = Object.entries(res);
                        const cities_field = document.getElementById("filter_city_id");
                        cities_field.innerHTML = `<option value=""> --- </option>`;
                        for(const [key,region] of entries){
                            console.log(key);
                            cities_field.innerHTML += `<option value="${key}">${region}</option>`;
                        }
                    }
                });
            });
        });
</script>
@endpush