@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Spouse Relationships</h1>
                    <p class="text-muted mb-0">Manage partner links inside the family tree.</p>
                </div>
                <a href="{{ route('admin.spouses.create') }}" class="btn btn-dark">
                    <i class="bi bi-plus-lg me-1"></i> Add Relationship
                </a>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Partner A</th>
                                <th>Partner B</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($spouses as $relationship)
                                <tr>
                                    <td>{{ $relationship->person->name }}</td>
                                    <td>{{ $relationship->partner->name }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.spouses.edit', $relationship) }}" class="btn btn-sm btn-outline-secondary me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.spouses.destroy', $relationship) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this relationship?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        No spouse relationships recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
@endsection
