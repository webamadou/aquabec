@extends('layouts.auth')

@section('title',"Connexion à l'Agenda Québec")
@section('sub-title',"Profitez de toutes les fonctionalités de l'Agenda du Québec en vous connectant")

@section('content')
    <form class="uk-child-width-1-1 uk-grid-small" uk-grid method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <div class="uk-form-group">
                <label for="email" class="uk-form-label">Nom D'utilisateur <small>ou</small> Adresse Email</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-mail"></i>
                    </span>
                    <input id="email" type="text" name="email" class="uk-input @error('email') is-invalid @enderror" placeholder="Votre adresse email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>
                @error('email')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div>
            <div class="uk-form-group">
                <label for="password" class="uk-form-label"> Mot de passe</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-lock"></i>
                    </span>
                    <input id="password" name="password" type="password" class="uk-input @error('password') is-invalid @enderror" >
                </div>
                <p class="text-right mb-0 pb-0"><a href="{{ route('password.request') }}">Mot de passe oublié ?</a></p>
                @error('password')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div>
            <div class="uk-form-group">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="font-weight-bold" for="remember">
                    Se souvenir de moi
                </label>
            </div>
        </div>

        <div>
            <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                <div class="uk-width-expand@s">
                    <p>Pas encore membre ? <br><a class="font-weight-bold text-primary" href="{{ route('register') }}">Créer un compte</a></p>
                </div>
                <div class="uk-width-auto@s">
                    <button type="submit" class="button primary">
                        Se Connecter
                        <i class="icon-feather-power ml-2"></i>
                    </button>
                </div>
            </div>
        </div>

    </form>

@endsection
