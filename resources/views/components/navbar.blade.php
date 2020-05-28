<nav class="navbar navbar-expand-md navbar-dark bg-danger shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand img-box text-center" href="{{ route('dashboard') }}">
            <img class="img-responsive-dashboard" src="{{ asset('images/simade-logo-crop.png') }}">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-uppercase text-white ml-5 mr-5" href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-uppercase text-white ml-5 mr-5" href="{{ route('inbox.maps') }}">Inbox By Maps</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-uppercase text-white ml-5 mr-5" href="{{ route('mytask') }}">My Task</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-uppercase text-white ml-5 mr-5" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>

            <span class="navbar-text pr-5 text-white">
                Updated <br>
                <span id="timer" class="text-warning"></span>
                <p>
                    {{ Str::title(Auth::user()->role) }}
                </p>
            </span>
        </div>
    </div>
</nav>
