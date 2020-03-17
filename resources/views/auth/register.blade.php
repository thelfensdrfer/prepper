@extends('layouts.auth')

@section('content')
<h2>{{ __('Register') }}</h2>

<form method="POST" action="{{ route('register') }}" class="w-full lg:w-1/2">
    @csrf

    <div class="mb-6">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-6">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-6">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-primary float-right">
        {{ __('Register') }}
    </button>

    <p>
        <a href="{{ route('login') }}">
            {{ __('Already got an account?') }}
        </a>
    </p>
</form>
@endsection
