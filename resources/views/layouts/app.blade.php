@extends('layouts.master')

@section('content_main')
    <body>
        <div id="app">
            <nav class="flex py-4 px-12 my-4">
                <ul class="list-none">
                    <li class="leading-none">
                        <a href="{{ route('landing') }}" class="py-0">
                            <img src="{{ asset('/images/logo.png') }}" alt="{{ config('app.name', 'Prepper') }}" class="h-12">
                        </a>
                    </li>
                </ul>
                <ul class="flex-grow list-none pt-1">
                    <li>
                        <a href="{{ route('food.index') }}">{{ __('Food') }}</a>
                    </li>
                    <li>
                        <a href="#">{{ __('Checklist') }}</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="flex-shrink list-none pt-1">
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

                            <form id="logout-form" class="hidden" action="{{ route('logout') }}" method="POST">
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
