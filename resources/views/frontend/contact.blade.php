@extends('layouts.front.master')

@section('title','Contactez Nous')

@section('content')

    <section id="tw-contact-us" class="tw-contact-us bg-offwhite">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-heading text-center">
                        <h2>
                            <small>Laissez un message</small>
                            Contacter l'administration de <span>l'Agenda du Québec</span>
                        </h2>
                        <span class="animate-border border-ash ml-auto mr-auto tw-mt-20 tw-mb-40"></span>
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
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control @error('name') border-danger is-invalid @enderror" name="name" id="name" placeholder="Nom et Prénoms" type="text" required="" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Col end -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control phone_number @error('phone') border-danger is-invalid @enderror " name="phone" id="phone" placeholder="Téléphone" type="text" value="{{ old('phone') }}">
                                @error('phone')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control @error('email') border-danger is-invalid @enderror" name="email" id="email" placeholder="Email" type="email" required="" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input class="form-control @error('subject') border-danger is-invalid @enderror" placeholder="Sujet" name="subject" id="subject" type="text" value="{{ old('subject') }}">
                                @error('subject')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea name="message" class="form-control form-message required-field @error('message') is-invalid @enderror" id="message" placeholder="Message" rows="5">{{ old('message') }}</textarea>
                                @error('message')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <!-- { !! htmlFormSnippet() !!} -->
                            </div>
                        </div>
                        <!-- Col 12 end -->
                    </div>
                    <!-- Form row end -->
                    <div class="text-center">
                        <button class="btn btn-primary tw-mt-30" type="submit">Envoyer</button>
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
