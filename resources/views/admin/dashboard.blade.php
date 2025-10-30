@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3">Welcome, {{ auth()->user()->name ?? 'Admin' }}</h1>
                    <p class="text-muted mb-0">Here is a quick overview of your family tree application.</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">Log out</button>
                </form>
            </div>

            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Total People</h5>
                            <p class="display-6 fw-bold mb-0">0</p>
                            <small class="text-muted">Add family members to build your tree.</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Spouse Links</h5>
                            <p class="display-6 fw-bold mb-0">0</p>
                            <small class="text-muted">Connect couples to enrich the tree.</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Articles</h5>
                            <p class="display-6 fw-bold mb-0">0</p>
                            <small class="text-muted">Share stories and history here.</small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Pending Tasks</h5>
                            <p class="display-6 fw-bold mb-0">0</p>
                            <small class="text-muted">Keep track of upcoming updates.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Getting Started</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Use the navigation sidebar to manage different parts of the application.</p>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Manage Family Tree to adjust relationships and structure.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Manage People to add or edit individual profiles.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Manage Spouses to link partners.
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Manage Articles to publish family stories.
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
@endsection
