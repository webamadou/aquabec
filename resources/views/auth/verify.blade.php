@extends('layouts.auth')

@section('title',"Confirmation")
@section('sub-title',"Vérifiez votre adresse email")

@section('content')
    @if (session('resent'))
        <p class="bg-success p-3 text-white text-center">
            Un nouveau lien de vérification a été envoyé à votre adresse email.
        </p>
    @endif

    <p class="text-center">
        Avant de continuer, veuillez vérifier vos emails, vous devriez avoir reçu un lien de vérification.
    </p>
    <p class="text-center font-weight-bold">
        Si vous n'avez pas reçu l'email, cliquez sur le bouton ci-dessous pour renvoyer à nouveau.
    </p>

    <form class="text-center" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="button primary ">Renvoyez l'email de confirmation</button>.
    </form>
@endsection
