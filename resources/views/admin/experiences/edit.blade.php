@extends('layouts.admin')

@section('title', 'Edit pengalaman')

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.experiences.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke pengalaman
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Pengalaman</p>
                <h1 class="admin-title">Edit pengalaman</h1>
                <p class="admin-lead">Perbarui detail {{ $experience->title }} dan dokumentasi pendukungnya.</p>
            </div>
        </header>

        <section class="admin-panel admin-form-panel">
            <form action="{{ route('admin.experiences.update', $experience) }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PUT')

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="category" class="admin-label">Kategori</label>
                        <select name="category" id="category" class="admin-select" required>
                            @foreach (['plk' => 'PLK', 'organization' => 'Organisasi', 'competition' => 'Lomba'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('category', $experience->category) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('category') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="role" class="admin-label">Peran</label>
                        <input type="text" name="role" id="role" value="{{ old('role', $experience->role) }}" class="admin-input" placeholder="Contoh: Ketua panitia">
                        @error('role') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-field">
                    <label for="title" class="admin-label">Judul pengalaman</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $experience->title) }}" class="admin-input" required>
                    @error('title') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="organization" class="admin-label">Organisasi / tempat</label>
                    <input type="text" name="organization" id="organization" value="{{ old('organization', $experience->organization) }}" class="admin-input" required>
                    @error('organization') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="description" class="admin-label">Deskripsi</label>
                    <textarea name="description" id="description" class="admin-textarea">{{ old('description', $experience->description) }}</textarea>
                    @error('description') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="start_date" class="admin-label">Tanggal mulai</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $experience->start_date->format('Y-m-d')) }}" class="admin-input" required>
                        @error('start_date') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="admin-field">
                        <label for="end_date" class="admin-label">Tanggal selesai</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $experience->end_date?->format('Y-m-d')) }}" class="admin-input">
                        <span class="admin-hint">Kosongkan jika masih berlangsung.</span>
                        @error('end_date') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-field">
                    <label for="documentation" class="admin-label">Dokumentasi</label>
                    <input type="file" name="documentation" id="documentation" accept="image/jpeg,image/png,image/gif,image/webp,application/pdf" class="admin-input">
                    <span class="admin-hint">Gambar atau PDF, maksimal 10 MB.</span>
                    @if ($experience->documentation)
                        <a href="{{ Storage::disk('public')->url($experience->documentation) }}" target="_blank" rel="noopener noreferrer" class="admin-file-link">
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
                    <a href="{{ route('admin.experiences.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
