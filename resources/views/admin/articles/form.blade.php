@extends('layouts.admin')

@section('title', $article->exists ? 'Edit blog' : 'Blog baru')

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.articles.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke artikel
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Blog</p>
                <h1 class="admin-title">{{ $article->exists ? 'Edit blog' : 'Tulis blog' }}</h1>
                <p class="admin-lead">Tulis catatan dengan bahasa yang jelas. Kosongkan waktu publikasi jika ingin menyimpannya sebagai draf.</p>
            </div>
        </header>

        <section class="admin-panel admin-form-panel">
            <form action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" class="admin-form">
                @csrf
                @if ($article->exists)
                    @method('PUT')
                @endif

                @if ($errors->any())
                    <div class="admin-alert admin-alert--danger" role="alert">
                        <i class="ri-error-warning-line" aria-hidden="true"></i>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="admin-field">
                    <label for="title" class="admin-label">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="admin-input" maxlength="255" required>
                    @error('title') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                <label for="body" class="admin-label">Isi blog</label>
                    <textarea name="body" id="body" class="admin-textarea" rows="16" style="min-height: 20rem;" required>{{ old('body', $article->body) }}</textarea>
                    @error('body') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="published_at" class="admin-label">Tanggal publikasi</label>
                    <input type="date" name="published_at" id="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d')) }}" class="admin-input">
                    <span class="admin-hint">Kosongkan untuk menyimpan sebagai draf. Isi tanggal di masa depan untuk menjadwalkan publikasi.</span>
                    @error('published_at') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="ri-save-line" aria-hidden="true"></i>
                        Simpan blog
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
