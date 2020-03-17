@extends('layouts.auth')

@section('content')
<h2>{{ __('Login') }}</h2>

<form method="POST" action="{{ route('login') }}" class="w-full lg:w-1/2">
    @csrf

    <div class="mb-6">
        <label for="email">{{ __('E-Mail Address') }}</label>

        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-6">
        <label for="password">{{ __('Password') }}</label>

        <input id="password" type="password" name="password" required autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <p>
            <a href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        </p>
    </div>

    <div class="mb-6">
        <label for="remember" class="cursor-pointer">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <span class="inline-block">
                {{ __('Remember Me') }}
            </span>
        </label>
    </div>

    <button type="submit" class="btn btn-primary float-right">
        {{ __('Login') }}
    </button>

    <p>
        <a href="{{ route('register') }}">
            {{ __('No account yet?') }}
        </a>
    </p>
</form>
@endsection
