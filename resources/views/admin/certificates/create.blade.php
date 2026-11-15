@extends('layouts.admin')

@section('title', 'Sertifikat baru')

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.certificates.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke sertifikat
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Sertifikat</p>
                <h1 class="admin-title">Sertifikat baru</h1>
                <p class="admin-lead">Simpan sertifikat, prestasi, atau penghargaan beserta dokumentasinya.</p>
            </div>
        </header>

        <section class="admin-panel admin-form-panel">
            <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="title" class="admin-label">Judul sertifikat</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="admin-input" required>
                        @error('title') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="date" class="admin-label">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ old('date') }}" class="admin-input">
                        @error('date') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-field">
                    <label for="description" class="admin-label">Deskripsi</label>
                    <textarea name="description" id="description" class="admin-textarea">{{ old('description') }}</textarea>
                    @error('description') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="documentation" class="admin-label">Dokumentasi</label>
                    <input type="file" name="documentation" id="documentation" accept="image/jpeg,image/png,image/gif,image/webp,application/pdf" class="admin-input">
                    <span class="admin-hint">Gambar atau PDF, maksimal 10 MB.</span>
                    @error('documentation') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="ri-save-line" aria-hidden="true"></i>
                        Simpan sertifikat
                    </button>
                    <a href="{{ route('admin.certificates.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
