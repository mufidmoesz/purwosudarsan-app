<nav class="admin-sidebar">
    <h4 class="fw-bold mb-4">Admin Panel</h4>
    <div class="list-group list-group-flush">
        <a
            href="{{ route('admin.dashboard') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        >
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a
            href="{{ route('tree') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('tree') ? 'active' : '' }}"
        >
            <i class="bi bi-diagram-3 me-2"></i> Manage Family Tree
        </a>
        <a
            href="{{ route('admin.people.index') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('admin.people.*') ? 'active' : '' }}"
        >
            <i class="bi bi-people me-2"></i> Manage People
        </a>
        <a
            href="{{ route('admin.spouses.index') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('admin.spouses.*') ? 'active' : '' }}"
        >
            <i class="bi bi-heart me-2"></i> Manage Spouses
        </a>
        <a
            href="{{ route('admin.articles.index') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"
        >
            <i class="bi bi-journal-text me-2"></i> Manage Articles
        </a>
    </div>
</nav>
