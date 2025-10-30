<nav class="navbar navbar-expand-md bg-dark fixed-top border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-light" href="{{ route('admin.dashboard') }}">
            Admin Panel
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#adminNavbar"
            aria-controls="adminNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
            <ul class="navbar-nav mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('admin.people.index') }}">People</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('admin.spouses.index') }}">Spouses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('tree') }}">View Tree</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-light px-0">Log out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
