@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Edit Person</h1>
                    <p class="text-muted mb-0">Update the details for {{ $person->name }}.</p>
                </div>
                <a href="{{ route('admin.people.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to list
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.people.update', $person) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name<span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $person->name) }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Select gender</option>
                                    <option value="male" {{ old('gender', $person->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $person->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Update Photo</label>
                                <input
                                    type="file"
                                    name="photo"
                                    class="form-control @error('photo') is-invalid @enderror"
                                    accept="image/*"
                                >
                                <small class="text-muted d-block mt-1">Leave empty to keep current photo (JPG, JPEG, PNG up to 2 MB)</small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($person->photo_url)
                                @php
                                    $currentPhoto = filter_var($person->photo_url, FILTER_VALIDATE_URL)
                                        ? $person->photo_url
                                        : asset('storage/' . ltrim($person->photo_url, '/'));
                                @endphp
                                <div class="col-md-3">
                                    <label class="form-label">Current Photo</label>
                                    <div class="border rounded p-2 bg-light text-center">
                                        <img src="{{ $currentPhoto }}" alt="{{ $person->name }}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-3">
                                <label class="form-label">Birth Date</label>
                                <input
                                    type="date"
                                    name="birth_date"
                                    class="form-control @error('birth_date') is-invalid @enderror"
                                    value="{{ old('birth_date', $person->birth_date) }}"
                                >
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Death Date</label>
                                <input
                                    type="date"
                                    name="death_date"
                                    class="form-control @error('death_date') is-invalid @enderror"
                                    value="{{ old('death_date', $person->death_date) }}"
                                >
                                @error('death_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Mother</label>
                                <select name="mother_id" class="form-select @error('mother_id') is-invalid @enderror">
                                    <option value="">Not set</option>
                                    @foreach ($people as $candidate)
                                        <option value="{{ $candidate->id }}" {{ (string) old('mother_id', $person->mother_id) === (string) $candidate->id ? 'selected' : '' }}>
                                            {{ $candidate->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('mother_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Father</label>
                                <select name="father_id" class="form-select @error('father_id') is-invalid @enderror">
                                    <option value="">Not set</option>
                                    @foreach ($people as $candidate)
                                        <option value="{{ $candidate->id }}" {{ (string) old('father_id', $person->father_id) === (string) $candidate->id ? 'selected' : '' }}>
                                            {{ $candidate->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('father_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $person->email) }}"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Phone</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $person->phone) }}"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input
                                    type="text"
                                    name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $person->city) }}"
                                >
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <input
                                    type="text"
                                    name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ old('country', $person->country) }}"
                                >
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $person->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-dark">
                                Update Person
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
@endsection
