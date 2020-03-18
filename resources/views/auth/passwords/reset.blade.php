@extends('layouts.app')

@section('content')
<h2>{{ __('Reset Password') }}</h2>

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="mb-6">
        <label for="email">{{ __('E-Mail Address') }}</label>

        <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="flex flex-wrap md:-mx-4">
        <div class="mb-6 w-full md:w-1/2 md:px-4">
            <label for="password">{{ __('Password') }}</label>

            <input id="password" type="password" name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-6 w-full md:w-1/2 md:px-4">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ __('Reset Password') }}
    </button>
</form>
@endsection
