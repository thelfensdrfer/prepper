@extends('layouts.app')

@section('content')
    <main class="text-center">
        <h1 class="mt-16"><span class="text-blue-500">{{ __('Be certain') }}</span> {{ __('of what you have in your pantry') }}</h1>

        <p class="text-2xl text-gray-700 mt-8 max-w-lg mx-auto">{{ __('Plan ahead for blackouts or other small and large catastrophes. Know that you are prepared because you have enough food, water, and other necessities for you and your family.') }}</p>

        <p class="mt-16">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('Get started') }}</a>
        </p>
    </main>
@endsection
