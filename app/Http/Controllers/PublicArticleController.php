<?php

namespace App\Http\Controllers;

use App\Models\Article;

class PublicArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderByDesc('created_at')->paginate(9);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}

