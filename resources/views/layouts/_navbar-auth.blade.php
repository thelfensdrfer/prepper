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
