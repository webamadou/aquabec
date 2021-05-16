@extends('layouts.front.master')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@section('title', $page->title)
@section('content')

    <section id="tw-contact-us" class="tw-contact-us bg-offwhite">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-heading text-center mb-0">
                        <h2>
                            <small>{{$page->subtitle}}</small>
                            <span>{{$page->title}} </span>
                        </h2>
                        <span class="animate-border border-ash ml-auto mr-auto tw-mt-20 tw-mb-40 mb-0"></span>
                    </div>
                </div>
            </div>
            <div class="contact-us-form">
                @forelse($page->faq_groups()->orderby('position','asc')->get() as $faq_group)
                <div id="accordion-{{$faq_group->id}}" class="accordion">
                    <h2>{{$faq_group->title}}</h2>
                    @foreach($faq_group->faqs as $faq)
                    <div class="group">
                        <h3>{{$faq->title}}</h3>
                        <div>{!! $faq->content !!}</div>
                    </div>
                    @endforeach
                </div>
                @empty
                    {!! $page->content !!}
                @endforelse
            </div>
            <div>
            </div>
        </div>
    </section>

@stop

@push('scripts')
    <script defer>
        $( function() {
            $( ".accordion" )
            .accordion({
                header: "> div > h3",
                heightStyle: "content",
                collapsible: true
            })
            .sortable({
                axis: "y",
                handle: "h3",
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( "h3" ).triggerHandler( "focusout" );
            
                    // Refresh accordion to handle new order
                    $( this ).accordion( "refresh" );
                }
            });
        } );
    </script>
@endpush