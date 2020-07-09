<nav id="nav-sticky" class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container pr-0 pl-md-2">
        <a href="{{ route('guest.home') }}">
            <img src="{{ asset('assets/logo/logo.png') }}" alt="Logo Lingkaran" class="logo mr-2">
        </a>
        <a class="navbar-brand" href="{{ route('guest.home') }}">Lingkar<span>an</span></a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars nav-icon"></i>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mt-2 mt-lg-0 ml-auto">

                <li class="nav-item {{ (request()->segment(1) == '') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('guest.home') }}">Home</a>
                </li>

                @foreach($navbar as $nav)
                <li class="nav-item {{ (request()->segment(1) == $nav->slug) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('guest.category.show', $nav) }}">{{ $nav->title }}</a>
                </li>
                @endforeach

                @if(auth()->user())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard.index') }}" style="color: red">Admin Panel</a>
                </li>
                @endif
            </ul>
            <livewire:search>
        </div>
    </div>
</nav>