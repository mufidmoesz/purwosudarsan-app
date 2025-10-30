@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Edit Spouse Relationship</h1>
                    <p class="text-muted mb-0">
                        Update partner pairing for
                        <strong>{{ optional($spouse->person)->name }}</strong>
                        and
                        <strong>{{ optional($spouse->partner)->name }}</strong>.
                    </p>
                </div>
                <a href="{{ route('admin.spouses.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to list
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.spouses.update', $spouse) }}">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Partner A<span class="text-danger">*</span></label>
                                <select name="person_id" class="form-select @error('person_id') is-invalid @enderror" required>
                                    <option value="">Select person</option>
                                    @foreach ($people as $person)
                                        <option value="{{ $person->id }}" {{ (string) old('person_id', $spouse->person_id) === (string) $person->id ? 'selected' : '' }}>
                                            {{ $person->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('person_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Partner B<span class="text-danger">*</span></label>
                                <select name="spouse_id" class="form-select @error('spouse_id') is-invalid @enderror" required>
                                    <option value="">Select partner</option>
                                    @foreach ($people as $person)
                                        <option value="{{ $person->id }}" {{ (string) old('spouse_id', $spouse->spouse_id) === (string) $person->id ? 'selected' : '' }}>
                                            {{ $person->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('spouse_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-dark">
                                Update Relationship
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
@endsection
