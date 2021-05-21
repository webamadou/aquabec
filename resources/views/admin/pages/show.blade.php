@extends('layouts.back.admin')

@section('title',$page->title)
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title font-weight-bold">-</h1>
                </div>
                @forelse($page->faq_groups as $faq_group)
                <div class="card-body my-2 faq_groups">
                    <h2>{{$faq_group->title}} </h2>
                    <div id="accordion-{{$faq_group->id}}" class="accordion">
                        @foreach($faq_group->faqs as $faq)
                        <div class="group">
                            <h3>{{$faq->title}}</h3>
                            <div>{!! $faq->content !!}</div>
                        </div>
                        @endforeach
                        <!-- <div class="group">
                            <h3>Section 2</h3>
                            <div>
                            <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
                            </div>
                        </div>
                        <div class="group">
                            <h3>Section 3</h3>
                            <div>
                            <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui. </p>
                            <ul>
                                <li>List item one</li>
                                <li>List item two</li>
                                <li>List item three</li>
                            </ul>
                            </div>
                        </div>
                        <div class="group">
                            <h3>Section 4</h3>
                            <div>
                            <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
                            </div>
                        </div>
                        </div> -->
                    </div>
                </div>
                @empty
                @endforelse
        </div>
    </div>

    @include('layouts.back.alerts.set-page-menus')

@stop

@push('scripts')


    <script defer>
        
    </script>

@endpush
