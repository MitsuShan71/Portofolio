<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PortfolioProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(15);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.form', ['article' => new Article()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['required', 'string'],
            'published_at' => ['nullable', 'date_format:Y-m-d'],
        ]);
        $validated['slug'] = $this->uniqueSlug($validated['title']);

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Blog berhasil dibuat.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['required', 'string'],
            'published_at' => ['nullable', 'date_format:Y-m-d'],
        ]);
        if ($article->title !== $validated['title']) {
            $validated['slug'] = $this->uniqueSlug($validated['title'], $article->id);
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Blog berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Blog berhasil dihapus.');
    }

    public function publicShow(Article $article)
    {
        abort_if(! $article->published_at || $article->published_at->isFuture(), 404);

        $profile = PortfolioProfile::first();

        return view('articles.show', compact('article', 'profile'));
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        $suffix = 2;

        while (Article::where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
