@extends('layouts.auth')

@section('title',"Créez votre compte")
@section('sub-title',"L'inscription est rapide et gratuite!")

@section('content')
    <form class="uk-child-width-1-1 uk-grid-small" uk-grid method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <div class="uk-form-group">
                <label for="email" class="uk-form-label"> Nom d'utilisateur (<small>obligatoire</small>)</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-smiley"></i>
                    </span>
                    <input id="username" type="text" name="username" class="uk-input @error('username') is-invalid @enderror" placeholder="Votre nom d'utilisateur" value="{{ old('username') }}" required autocomplete="username">
                </div>
                @error('email')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <hr>
        <div class="uk-width-1-2@s">
            <div class="uk-form-group">
                <label for="last-name" class="uk-form-label"> Nom (<small>obligatoire</small>)</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-user"></i>
                    </span>
                    <input id="last-name" type="text" name="name" class="uk-input" value="{{ old('name') }}" required placeholder="Votre nom de famille">
                </div>
                @error('name')
                <span class="text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
        </div>
        <div class="uk-width-1-2@s">
            <div class="uk-form-group">
                <label for="first-name" class="uk-form-label"> Prénom</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-user"></i>
                    </span>
                    <input id="first-name" type="text" name="prenom" class="uk-input" value="{{ old('prenom') }}" required placeholder="Votre prénom">
                </div>
                @error('prenom')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div>
            <div class="uk-form-group">
                <label for="email" class="uk-form-label"> Adresse Email (<small>obligatoire</small>)</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-mail"></i>
                    </span>
                    <input id="email" type="email" name="email" class="uk-input @error('email') is-invalid @enderror" placeholder="Votre adresse email" value="{{ old('email') }}" required autocomplete="email">
                </div>
                @error('email')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="uk-width-1-2@s">
            <div class="uk-form-group">
                <label class="uk-form-label"> Mot de passe (<small>obligatoire</small>) </label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" class="uk-input"  placeholder="Votre mot de passe">
                </div>
                @error('password')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="uk-width-1-2@s">
            <div class="uk-form-group">
                <label for="password-confirm" class="uk-form-label"> Confirmez <br>(<small>obligatoire</small>)</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-lock"></i>
                    </span>
                    <input id="password-confirm" type="password" name="password_confirmation" class="uk-input" placeholder="Confirmation du mot de passe">
                </div>
            </div>
        </div>
        <div>
            <div class="uk-form-group">
                <input type="checkbox" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }} required>
                <label class="font-weight-bold" for="terms">
                    J'accepte les conditions d'utilisation
                </label>
                @error('terms')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <div>
            <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                <div class="uk-width-expand@s">
                    <p>Vous avez un compte ? <br><a class="font-weight-bold text-primary" href="{{ route('login') }}">Connectez vous</a></p>
                </div>
                <div class="uk-width-auto@s">
                    <button type="submit" class="button primary">
                        S'inscrire
                        <i class="icon-feather-user-plus ml-2"></i>
                    </button>
                </div>
            </div>
        </div>
        <p class="text-center font-italic text-dark" style="font-size: small">
            En cliquant sur le bouton "S'inscrire" vous acceptez expressément de recevoir nos communications commerciales électroniques.
        </p>

    </form>

@endsection
