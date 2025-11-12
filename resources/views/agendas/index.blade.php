@extends('layout.layout')

@section('content')
    <div class="container py-5 mt-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Agenda Kegiatan</h1>
        </div>

        @if ($agendas->isEmpty())
            <div class="alert alert-info text-center">
                Tidak ada agenda kegiatan yang akan datang saat ini.
            </div>
        @else
            <div class="row g-4">
                @foreach ($agendas as $agenda)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-semibold">{{ $agenda->name }}</h5>
                                <p class="text-muted mb-2">
                                    {{ \Illuminate\Support\Carbon::parse($agenda->date)->format('l, d M Y') }}
                                    &middot;
                                    {{ \Illuminate\Support\Str::substr($agenda->time, 0, 5) }}
                                </p>
                                @if ($agenda->location)
                                    <p class="mb-2"><strong>Location:</strong> {{ $agenda->location }}</p>
                                @endif
                                <p class="card-text text-muted flex-grow-1">
                                    {{ $agenda->description ? \Illuminate\Support\Str::limit($agenda->description, 150) : 'No description provided.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($agendas->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $agendas->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @endif
    </div>
@endsection
