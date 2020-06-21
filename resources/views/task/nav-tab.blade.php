<ul class="nav nav-pills nav-fill mb-2">
    <li class="nav-item">
        <a class="nav-link {{ $active == 'overview' ? 'bg-danger text-white' : 'bg-light text-muted' }} font-weight-bold text-uppercase py-3" href="{{ route('task.overview') }}">
            Overview
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $active == 'search' ? 'bg-danger text-white' : 'bg-light text-muted' }} font-weight-bold text-uppercase py-3" href="{{ route('task.search') }}">
            Search
        </a>
    </li>
</ul>
