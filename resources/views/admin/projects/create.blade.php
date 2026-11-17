@extends('layouts.admin')

@section('title', 'Proyek baru')

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.projects.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke proyek
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Proyek</p>
                <h1 class="admin-title">Proyek baru</h1>
                <p class="admin-lead">Isi informasi proyek sedetail mungkin supaya pengunjung memahami proses dan hasil kerjamu.</p>
            </div>
        </header>

        <section class="admin-panel admin-form-panel">
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                <div class="admin-field">
                    <label for="title" class="admin-label">Judul proyek</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="admin-input" required>
                    @error('title') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="category" class="admin-label">Kategori proyek</label>
                    <input type="text" name="category" id="category" value="{{ old('category') }}" class="admin-input" placeholder="UI/UX, Website, Infografis">
                    <span class="admin-hint">Kategori ini akan menjadi pilihan filter di portofolio.</span>
                    @error('category') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="role" class="admin-label">Peran</label>
                    <input type="text" name="role" id="role" value="{{ old('role') }}" class="admin-input" placeholder="UI/UX Designer">
                    @error('role') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="technologies" class="admin-label">Teknologi</label>
                    <input type="text" name="technologies" id="technologies" value="{{ old('technologies') }}" class="admin-input" placeholder="Laravel, MySQL">
                    <span class="admin-hint">Pisahkan dengan koma. Teknologi ini juga digunakan untuk filter proyek.</span>
                    @error('technologies') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="demo_link" class="admin-label">Tautan</label>
                    <input type="url" name="demo_link" id="demo_link" value="{{ old('demo_link') }}" class="admin-input" placeholder="https://...">
                    <span class="admin-hint">Bisa tautan demo atau GitHub.</span>
                    @error('demo_link') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="image" class="admin-label">Gambar utama</label>
                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp" class="admin-input">
                    <span class="admin-hint">Opsional. Gunakan JPG, PNG, atau WebP dengan ukuran maksimal 2 MB.</span>
                    @error('image') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="ri-save-line" aria-hidden="true"></i>
                        Simpan proyek
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
