@extends('layouts.auth')

@section('title',"Changer de mot de passe")
@section('sub-title',"Créez un nouveau mot de passe pour votre compte")

@section('content')
    <form class="uk-child-width-1-1 uk-grid-small" uk-grid method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <div class="uk-form-group">
                <label for="email" class="uk-form-label"> Adresse Email</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-mail"></i>
                    </span>
                    <input id="email" type="email" name="email" class="uk-input @error('email') is-invalid @enderror" placeholder="Votre adresse email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                </div>
                @error('email')
                <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
        <div class="">
            <div class="uk-form-group">
                <label class="uk-form-label">Nouveau mot de passe</label>
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
        <div class="">
            <div class="uk-form-group">
                <label for="password-confirm" class="uk-form-label"> Confirmez le mot de passe</label>
                <div class="uk-position-relative w-100">
                    <span class="uk-form-icon">
                        <i class="icon-feather-lock"></i>
                    </span>
                    <input id="password-confirm" type="password" name="password_confirmation" class="uk-input" placeholder="Confirmation du nouveau mot de passe">
                </div>
            </div>
        </div>

        <div>
            <div class="mt-4 uk-flex-middle uk-grid-small" uk-grid>
                <div class="uk-width-expand@s">
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
