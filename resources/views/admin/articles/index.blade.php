@extends('layouts.admin')

@section('title', 'Artikel')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Konten</p>
                <h1 class="admin-title">Artikel</h1>
                <p class="admin-lead">Tulis catatan ngoding dan cerita proses desain. Artikel berstatus draf tidak akan tampil di halaman publik.</p>
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.articles.create') }}" class="admin-btn admin-btn--primary">
                    <i class="ri-quill-pen-line" aria-hidden="true"></i>
                    Tulis artikel
                </a>
            </div>
        </header>

        @if (session('success'))
            <div class="admin-alert" role="status">
                <i class="ri-checkbox-circle-line" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
        @endif

        <section class="admin-panel">
            <div class="admin-panel__head">
                <div>
                    <h2 class="admin-panel__title">Daftar artikel</h2>
                    <p>{{ $articles->total() }} artikel tersimpan</p>
                </div>
            </div>

            @if ($articles->isEmpty())
                <div class="admin-empty">
                    <i class="ri-article-line" aria-hidden="true"></i>
                    <strong>Belum ada artikel</strong>
                    <p>Mulai tulis catatan pertama untuk mengisi blog pengembang.</p>
                    <a href="{{ route('admin.articles.create') }}" class="admin-btn admin-btn--primary">
                        <i class="ri-quill-pen-line" aria-hidden="true"></i>
                        Tulis artikel
                    </a>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Artikel</th>
                                <th>Status</th>
                                <th>Publikasi</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                @php
                                    $isPublished = $article->published_at && $article->published_at->isPast();
                                    $isScheduled = $article->published_at && $article->published_at->isFuture();
                                @endphp
                                <tr>
                                    <td>
                                        <div class="admin-table__primary">{{ $article->title }}</div>
                                        <div class="admin-table__meta">
                                            {{ $article->excerpt ? \Illuminate\Support\Str::limit($article->excerpt, 100) : \Illuminate\Support\Str::limit(strip_tags($article->body), 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($isPublished)
                                            <span class="admin-badge admin-badge--live">Terbit</span>
                                        @elseif ($isScheduled)
                                            <span class="admin-badge">Terjadwal</span>
                                        @else
                                            <span class="admin-badge">Draf</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">
                                            {{ $article->published_at?->format('d M Y, H:i') ?? 'Belum dipublikasikan' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            @if ($isPublished)
                                                <a href="{{ route('articles.show', $article->slug) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Lihat {{ $article->title }}" title="Lihat di situs" target="_blank" rel="noopener noreferrer">
                                                    <i class="ri-eye-line" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.articles.edit', $article) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Edit {{ $article->title }}" title="Edit">
                                                <i class="ri-edit-line" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="admin-inline-form" data-confirm="Hapus artikel ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus {{ $article->title }}" title="Hapus">
                                                    <i class="ri-delete-bin-line" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $articles->links('pagination.admin') }}
            @endif
        </section>
    </div>
@endsection
