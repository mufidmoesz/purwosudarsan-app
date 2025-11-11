@extends('layout.layout')

@section('content')
    <div class="container py-5 mt-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Artikel</h1>
        </div>

        @if ($articles->isEmpty())
            <div class="alert alert-info text-center">
                No articles available yet. Check back soon!
            </div>
        @else
            <div class="row g-4">
                @foreach ($articles as $article)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-semibold">{{ $article->title }}</h5>
                                <small class="text-muted mb-3">
                                    By {{ $article->author }} &middot; {{ $article->created_at?->format('d M Y') }}
                                </small>
                                <p class="card-text text-muted flex-grow-1">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 150) }}
                                </p>
                                <a href="{{ route('articles.show', $article) }}" class="btn btn-dark mt-auto">
                                    Read more
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($articles->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $articles->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @endif
    </div>
@endsection
