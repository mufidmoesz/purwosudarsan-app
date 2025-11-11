@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Create Article</h1>
                    <p class="text-muted mb-0">Share new stories or announcements.</p>
                </div>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to list
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.articles.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Title<span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Author<span class="text-danger">*</span></label>
                            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author') }}" required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content<span class="text-danger">*</span></label>
                            <textarea name="content" id="article-content-editor" rows="10" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark">Publish Article</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    @once
        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof CKEDITOR !== 'undefined' && document.getElementById('article-content-editor')) {
                CKEDITOR.replace('article-content-editor', {
                    height: 400
                });
            }
        });
    </script>
@endpush
