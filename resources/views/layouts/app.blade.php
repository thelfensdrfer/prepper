@extends('layouts.master')

@section('content_main')
    <body>
        <div id="app">
            <nav class="flex flex-wrap py-4 px-12 my-4">
                <!-- Logo -->
                <ul class="list-none flex-grow lg:flex-grow-0">
                    <li class="leading-none">
                        <a href="{{ route('landing') }}" class="py-0">
                            <img src="{{ asset('/images/logo.png') }}" alt="{{ config('app.name', 'Prepper') }}" class="h-12">
                        </a>
                    </li>
                </ul>

                <!-- Left Side Of Navbar -->
                <ul class="hidden lg:inline-block lg:flex-grow list-none ml-4 pt-1">
                    @include('layouts._navbar-main')
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="hidden lg:inline-block lg:flex-shrink list-none pt-1">
                    @include('layouts._navbar-auth')
                </ul>

                <!-- Hamburger menu -->
                <ul class="inline-block lg:hidden list-none pt-1">
                    <li>
                        <a class="cursor-pointer" @click="openResponsiveNavbar">
                            <i class="far fa-bars" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </nav>

            <div id="navbar-responsive" class="hidden flex flex-col justify-center inset-0 my">
                <div class="w-9/12 mx-auto">
                    <div class="text-right -mr-4">
                        <a class="cursor-pointer text-white text-4xl p-4" @click="closeResponsiveNavbar" title="{{ __('Close navigation') }}">
                            <i class="far fa-times" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <ul class="text-center w-9/12 mx-auto">
                    @include('layouts._navbar-main')
                    @include('layouts._navbar-auth')
                </ul>
            </div>

            <div class="border-b border-gray-200"></div>

            <main class="px-8 py-8 md:px-16">
                @include('flash::message')

                @yield('content')
            </main>
        </div>
    </body>
@endsection
