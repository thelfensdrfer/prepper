@extends('layouts.master')

@section('content_main')
    <body>
        <div id="app">
            <nav class="flex py-4 px-12 my-4">
                <ul class="flex-grow">
                    <li class="leading-none">
                        <a href="{{ route('landing') }}" class="py-0">
                            <img src="{{ asset('/images/logo.png') }}" alt="{{ config('app.name', 'Prepper') }}" class="h-12">
                        </a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="flex-shrink list-none">
                    <!-- Authentication Links -->
                    @guest
                        <li>
                            <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>

                        <li>
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li>
                            <a href="#">
                                {{ Auth::user()->email }}
                            </a>
                        </li>

                        <li>
                            <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </nav>

            <main class="py-4 px-16">
                @include('flash::message')

                @yield('content')
            </main>
        </div>
    </body>
@endsection
