@extends('layouts.app')

@section('content')
<h2>{{ __('Reset Password') }}</h2>

@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-6">
        <label for="email">{{ __('E-Mail Address') }}</label>

        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        {{ __('Send Password Reset Link') }}
    </button>
</form>
@endsection
