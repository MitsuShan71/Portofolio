@extends('layouts.admin')

@section('title', 'Edit proyek')

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.projects.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke proyek
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Proyek</p>
                <h1 class="admin-title">Edit proyek</h1>
                <p class="admin-lead">Perbarui informasi {{ $project->title }}. Perubahan langsung tampil di halaman publik.</p>
            </div>
        </header>

        <section class="admin-panel admin-form-panel">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-field">
                    <label for="title" class="admin-label">Judul proyek</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" class="admin-input" required>
                    @error('title') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="description" class="admin-label">Deskripsi singkat</label>
                    <textarea name="description" id="description" class="admin-textarea">{{ old('description', $project->description) }}</textarea>
                    @error('description') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                @foreach ([
                    'problem_solved' => 'Masalah yang diselesaikan',
                    'objective' => 'Tujuan proyek',
                    'technologies' => 'Teknologi yang digunakan',
                    'role' => 'Peran',
                    'features' => 'Fitur utama',
                    'process_documentation' => 'Dokumentasi proses',
                    'user_feedback' => 'Umpan balik pengguna',
                    'details' => 'Detail tambahan',
                ] as $field => $label)
                    <div class="admin-field">
                        <label for="{{ $field }}" class="admin-label">{{ $label }}</label>
                        <textarea name="{{ $field }}" id="{{ $field }}" class="admin-textarea">{{ old($field, $project->{$field}) }}</textarea>
                        @error($field) <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                @endforeach

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="demo_link" class="admin-label">Tautan demo</label>
                        <input type="url" name="demo_link" id="demo_link" value="{{ old('demo_link', $project->demo_link) }}" class="admin-input" placeholder="https://...">
                        @error('demo_link') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="admin-field">
                        <label for="github_link" class="admin-label">Tautan GitHub</label>
                        <input type="url" name="github_link" id="github_link" value="{{ old('github_link', $project->github_link) }}" class="admin-input" placeholder="https://...">
                        @error('github_link') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-field">
                    <label for="link" class="admin-label">Tautan tambahan</label>
                    <input type="url" name="link" id="link" value="{{ old('link', $project->link) }}" class="admin-input" placeholder="https://...">
                    @error('link') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="image" class="admin-label">Gambar utama</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp" class="admin-input" @if (!$project->image) required @endif>
                    <span class="admin-hint">{{ $project->image ? 'Biarkan kosong jika tidak ingin mengganti gambar.' : 'Gambar wajib diunggah untuk proyek baru.' }} Maksimal 2 MB.</span>
                    @if ($project->image)
                        <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="admin-preview">
                    @endif
                    @error('image') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="ri-save-line" aria-hidden="true"></i>
                        Simpan perubahan
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
