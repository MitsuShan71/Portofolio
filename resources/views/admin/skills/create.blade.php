@extends('layouts.admin')

@section('title', 'Keahlian baru')

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.skills.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke keahlian
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Keahlian</p>
                <h1 class="admin-title">Keahlian baru</h1>
                <p class="admin-lead">Tambahkan hard skill atau soft skill beserta persentase penguasaannya.</p>
            </div>
        </header>

        <section class="admin-panel admin-form-panel">
            <form action="{{ route('admin.skills.store') }}" method="POST" class="admin-form">
                @csrf

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="name" class="admin-label">Nama keahlian</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="admin-input" required>
                        @error('name') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="category" class="admin-label">Kategori</label>
                        <select name="category" id="category" class="admin-select" required>
                            <option value="hard" @selected(old('category') === 'hard')>Hard skill</option>
                            <option value="soft" @selected(old('category') === 'soft')>Soft skill</option>
                        </select>
                        @error('category') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="percentage" class="admin-label">Persentase</label>
                        <input type="number" name="percentage" id="percentage" min="0" max="100" step="1" value="{{ old('percentage') }}" class="admin-input" required>
                        <span class="admin-hint">Nilai 0 sampai 100.</span>
                        @error('percentage') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="sort_order" class="admin-label">Urutan tampil</label>
                        <input type="number" name="sort_order" id="sort_order" min="0" step="1" value="{{ old('sort_order', 0) }}" class="admin-input">
                        @error('sort_order') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="ri-save-line" aria-hidden="true"></i>
                        Simpan keahlian
                    </button>
                    <a href="{{ route('admin.skills.index') }}" class="admin-btn admin-btn--ghost">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
