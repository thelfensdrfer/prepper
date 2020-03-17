@extends('layouts.master')

@section('content_main')
    <body class="flex flex-col" id="body-auth">
        <div id="app" class="flex-grow">
            <nav class="flex py-8 px-16">
                <ul class="flex-grow">
                    <li>
                        <a href="{{ route('landing') }}">
                            <img src="{{ asset('/images/logo.png') }}" alt="{{ config('app.name', 'Prepper') }}" class="h-12">
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-16 flex flex-wrap">
                <div class="w-full lg:w-1/2">
                    @include('flash::message')

                    @yield('content')
                </div>

                <div class="w-full lg:w-1/2 mt-8 lg:mt-0">
                    <img class="float-right" src="/images/auth.svg" alt="Two people sharing food.">
                </div>
            </div>
        </div>
    </body>
@endsection
