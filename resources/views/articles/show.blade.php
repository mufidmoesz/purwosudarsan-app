@extends('layout.layout')

@section('content')
    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="mb-4">
                    <a href="{{ route('articles.index') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-arrow-left me-1"></i> Back to articles
                    </a>
                </div>

                <article class="card shadow-sm border-0">
                    <div class="card-body">
                        <h1 class="card-title display-6">{{ $article->title }}</h1>
                        <div class="text-muted mb-4">
                            By {{ $article->author }} &middot; {{ $article->created_at?->format('d M Y') }}
                        </div>
                        <div class="article-content">
                            {!! $article->content !!}
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection
