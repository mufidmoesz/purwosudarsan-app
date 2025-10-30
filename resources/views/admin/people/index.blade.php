@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">People</h1>
                    <p class="text-muted mb-0">Manage individuals within the family tree.</p>
                </div>
                <a href="{{ route('admin.people.create') }}" class="btn btn-dark">
                    <i class="bi bi-plus-lg me-1"></i> Add Person
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
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Parents</th>
                                <th>Location</th>
                                <th>Spouses</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($people as $person)
                                @php
                                    $photo = null;
                                    if ($person->photo_url) {
                                        $photo = filter_var($person->photo_url, FILTER_VALIDATE_URL)
                                            ? $person->photo_url
                                            : asset('storage/' . ltrim($person->photo_url, '/'));
                                    }
                                @endphp
                                <tr>
                                    <td style="width: 70px;">
                                        @if ($photo)
                                            <img src="{{ $photo }}" alt="{{ $person->name }}" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $person->name }}</div>
                                        @if ($person->birth_date)
                                            <small class="text-muted">Born: {{ \Illuminate\Support\Carbon::parse($person->birth_date)->toFormattedDateString() }}</small>
                                        @endif
                                        @if ($person->death_date)
                                            <br><small class="text-muted">Died: {{ \Illuminate\Support\Carbon::parse($person->death_date)->toFormattedDateString() }}</small>
                                        @endif
                                    </td>
                                    <td class="text-capitalize">{{ $person->gender ?? '—' }}</td>
                                    <td>
                                        <small class="d-block text-muted">
                                            <span class="fw-semibold">Mother:</span> {{ optional($person->mother)->name ?? 'Unknown' }}
                                        </small>
                                        <small class="d-block text-muted">
                                            <span class="fw-semibold">Father:</span> {{ optional($person->father)->name ?? 'Unknown' }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="d-block text-muted">{{ $person->city ?? '—' }}</small>
                                        <small class="d-block text-muted">{{ $person->country ?? '—' }}</small>
                                    </td>
                                    <td>{{ $person->spouses_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.people.edit', $person) }}" class="btn btn-sm btn-outline-secondary me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.people.destroy', $person) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this person?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No people found. Add someone to get started.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($people->hasPages())
                    <div class="card-footer bg-white">
                        {{ $people->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
