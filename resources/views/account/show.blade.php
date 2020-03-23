@extends('layouts.app')

@section('content')
    <h2 class="mb-8">{{ __('Your Account') }}</h2>

    <div class="flex flex-wrap lg:-mx-8">
        <div class="w-full lg:w-1/2 lg:px-8">
            <h3>{{ __('Update personal information') }}</h3>

            <form action="{{ route('account.update') }}" method="post">
                <input type="hidden" name="_method" value="put">

                @csrf

                <div class="mb-4">
                    <label for="email">{{ __('E-Mail *') }}</label>

                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" required>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="timezone">{{ __('Timezone *') }}</label>

                    <div class="block relative">
                        <select name="timezone" id="timezone" required>
                            @foreach ($timezones as $timezone)
                                <option value="{{ $timezone }}" @if (auth()->user()->timezone === $timezone) selected="selected" @endif>{{ $timezone }}</option>
                            @endforeach
                        </select>

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="far fa-chevron-down" aria-hidden="true"></i>
                        </div>
                    </div>

                    @error('timezone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="far fa-save" aria-hidden="true"></i> {{ __('Save') }}
                </button>
            </form>
        </div>

        <div class="w-full mt-8 lg:w-1/2 lg:px-8 lg:mt-0">
            <h3>{{ __('Change Your Password') }}</h3>

            <form action="{{ route('account.password') }}" method="post">
                <input type="hidden" name="_method" value="put">

                @csrf

                <div class="mb-4">
                    <label for="current-password">{{ __('Current password *') }}</label>

                    <input type="password" id="current-password" name="current_password" required>

                    @error('current_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password">{{ __('New password *') }}</label>

                    <input type="password" id="password" name="password" required min="8">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm">{{ __('Repeat new password *') }}</label>

                    <input type="password" id="password-confirm" name="password_confirmation" required>

                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="far fa-save" aria-hidden="true"></i> {{ __('Change password') }}
                </button>
            </form>
        </div>

        <div class="w-full mt-8 lg:w-1/2 lg:px-8">
            <h3>{{ __('Update Email Reminders') }}</h3>

            <form action="{{ route('account.reminder') }}" method="post">
                <input type="hidden" name="_method" value="put">

                @csrf

                <div class="mb-4">
                    <input type="hidden" name="reminder_expired_food" value="0">

                    <label class="font-bold cursor-pointer">
                        <input class="mr-2 leading-tight" type="checkbox" name="reminder_expired_food" id="reminder-expired-food" value="1" @if (auth()->user()->reminder_expired_food) checked="checked" @endif>

                        Weekly email with the food which is about to expire in the next 30 days.
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="far fa-save" aria-hidden="true"></i> {{ __('Save reminder') }}
                </button>
            </form>
        </div>
    </div>
@endsection
