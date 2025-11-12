@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Agendas</h1>
                    <p class="text-muted mb-0">Keep track of upcoming family events.</p>
                </div>
                <a href="{{ route('admin.agendas.create') }}" class="btn btn-dark">
                    <i class="bi bi-plus-lg me-1"></i> New Agenda
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
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Location</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($agendas as $agenda)
                                <tr>
                                    <td class="fw-semibold">{{ $agenda->name }}</td>
                                    <td>{{ \Illuminate\Support\Carbon::parse($agenda->date)->format('d M Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::substr($agenda->time, 0, 5) }}</td>
                                    <td>{{ $agenda->location ?? '—' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.agendas.edit', $agenda) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                                        <form action="{{ route('admin.agendas.destroy', $agenda) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this agenda?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No agendas yet. Create one to schedule upcoming events.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($agendas->hasPages())
                    <div class="card-footer bg-white">
                        {{ $agendas->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
