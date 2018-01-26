<nav class="navbar navbar-default navbar-expand-lg mb-5 sticky-top">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('wow.guild.name', 'My Guild') }}</a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarContent">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item"><a class="nav-link" href="{{ url('/raids') }}">Raids</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/characters') }}">Characters</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/leaderboards') }}">Leaderboards</a></li>
            @if (Auth::guest())
                <a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                <a class="nav-link" href="{{ url('/register') }}">Register</a></li>
            @else
                @if (Gate::allows('administrate'))
                    <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
                @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>

                            <a class="dropdown-item" href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
            @endif
        </ul>
    </div>
</nav>
