@extends('layouts.admin')

@section('title', 'Edit sertifikat')

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.certificates.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke sertifikat
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Sertifikat</p>
                <h1 class="admin-title">Edit sertifikat</h1>
                <p class="admin-lead">Perbarui detail {{ $certificate->title }} atau ganti dokumentasinya.</p>
            </div>
        </header>

        <section class="admin-panel admin-form-panel">
            <form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="title" class="admin-label">Judul sertifikat</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $certificate->title) }}" class="admin-input" required>
                        @error('title') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="date" class="admin-label">Tanggal</label>
                        <input type="date" name="date" id="date" value="{{ old('date', $certificate->date?->format('Y-m-d')) }}" class="admin-input">
                        @error('date') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-field">
                    <label for="description" class="admin-label">Deskripsi</label>
                    <textarea name="description" id="description" class="admin-textarea">{{ old('description', $certificate->description) }}</textarea>
                    @error('description') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="documentation" class="admin-label">Dokumentasi</label>
                    <input type="file" name="documentation" id="documentation" accept="image/jpeg,image/png,image/gif,image/webp,application/pdf" class="admin-input">
                    <span class="admin-hint">Biarkan kosong jika tidak ingin mengganti dokumentasi. Maksimal 10 MB.</span>
                    @if ($certificate->documentation)
                        <a href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer" class="admin-file-link">
                            <i class="ri-file-line" aria-hidden="true"></i>
                            Lihat dokumentasi saat ini
                        </a>
                    @endif
                    @error('documentation') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="ri-save-line" aria-hidden="true"></i>
                        Simpan perubahan
                    </button>
                    <a href="{{ route('admin.certificates.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
