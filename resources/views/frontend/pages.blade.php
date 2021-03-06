@extends('layouts.front.master')

@section('title', $page->title)

@section('content')

    <section id="tw-contact-us" class="tw-contact-us bg-offwhite">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-heading text-center">
                        <h2>
                            <small>{{$page->subtitle}}</small>
                            <span>{{$page->title}} </span>
                        </h2>
                        <span class="animate-border border-ash ml-auto mr-auto tw-mt-20 tw-mb-40"></span>
                    </div>
                </div>
            </div>
            <div class="contact-us-form">
                {!! $page->content !!}
            </div>
        </div>
    </section>

@stop
