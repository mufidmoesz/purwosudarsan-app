<nav class="navbar navbar-expand-md bg-dark fixed-top border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-light" href="{{ route('tree') }}">
            Silsilah Purwosudarsan
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('tree') }}">Family Tree</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/articles') }}">Articles</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
