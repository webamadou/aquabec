@extends('layouts.auth')

@section('title',"Mot de passe perdu")
@section('sub-title',"Veuillez entrer l'adresse email correspondant à votre compte pour recevoir le lien de réinitialisation du mot de passe.")

@section('content')
    @if (session('status'))
        <p class="bg-success p-3 text-white text-center">
            {{ session('status') }}
        </p>
    @endif
    <form class="uk-child-width-1-1 uk-grid-small" uk-grid method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <div class="uk-form-group">
                <label for="email" class="uk-form-label"> Adresse Email</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-mail"></i>
                    </span>
                    <input id="email" type="email" name="email" class="uk-input @error('email') is-invalid @enderror" placeholder="Votre adresse email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div>
            <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                <div class="uk-width-expand@s">
                    <p>Mémoire retrouvé ? <br><a class="font-weight-bold text-primary" href="{{ route('login') }}">Connectez vous</a></p>
                </div>
                <div class="uk-width-auto@s">
                    <button type="submit" class="button primary">
                        Continuer
                        <i class="icon-feather-arrow-right-circle ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

    </form>

@endsection
