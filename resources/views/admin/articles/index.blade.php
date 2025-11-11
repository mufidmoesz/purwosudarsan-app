@extends('layout.admin')

@section('content')
    <div class="admin-layout d-lg-flex">
        @include('admin.partials.sidebar')

        <main class="admin-main flex-grow-1">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Articles</h1>
                    <p class="text-muted mb-0">Manage stories and updates for the family.</p>
                </div>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-dark">
                    <i class="bi bi-plus-lg me-1"></i> New Article
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
                                <th>Title</th>
                                <th>Author</th>
                                <th>Published</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articles as $article)
                                <tr>
                                    <td class="fw-semibold">{{ $article->title }}</td>
                                    <td>{{ $article->author }}</td>
                                    <td>{{ $article->created_at?->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-outline-secondary me-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this article?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        No articles found. Create one to share family stories.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($articles->hasPages())
                    <div class="card-footer bg-white">
                        {{ $articles->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
