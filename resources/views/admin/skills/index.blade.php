@extends('layouts.admin')

@section('title', 'Keahlian')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Konten</p>
                <h1 class="admin-title">Keahlian</h1>
                <p class="admin-lead">Atur hard skill dan soft skill beserta persentase yang tampil di halaman utama.</p>
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.skills.create') }}" class="admin-btn admin-btn--primary">
                    <i class="ri-add-line" aria-hidden="true"></i>
                    Keahlian baru
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
                    <h2 class="admin-panel__title">Daftar keahlian</h2>
                    <p>{{ $skills->count() }} keahlian tersimpan</p>
                </div>
            </div>

            @if ($skills->isEmpty())
                <div class="admin-empty">
                    <i class="ri-bar-chart-line" aria-hidden="true"></i>
                    <strong>Belum ada keahlian</strong>
                    <p>Tambahkan skill agar bagian keahlian di halaman publik terisi.</p>
                    <a href="{{ route('admin.skills.create') }}" class="admin-btn admin-btn--primary">
                        <i class="ri-add-line" aria-hidden="true"></i>
                        Tambah keahlian
                    </a>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Keahlian</th>
                                <th>Kategori</th>
                                <th>Persentase</th>
                                <th>Urutan</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($skills as $skill)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.7rem;">
                                            @if ($skill->icon && str_starts_with($skill->icon, 'skills/'))
                                                <img src="{{ Storage::url($skill->icon) }}" alt="" class="admin-table__thumb" style="width: 2.2rem; height: 2.2rem; object-fit: contain; padding: 0.3rem;">
                                            @else
                                                <span class="admin-table__placeholder" style="width: 2.2rem; height: 2.2rem; flex: 0 0 auto;">
                                                    <i class="{{ $skill->icon ?: 'ri-code-s-slash-line' }}" aria-hidden="true"></i>
                                                </span>
                                            @endif
                                            <span class="admin-table__primary">{{ $skill->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="admin-badge {{ $skill->category === 'hard' ? 'admin-badge--live' : '' }}">
                                            {{ $skill->category === 'hard' ? 'Hard skill' : 'Soft skill' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="admin-meter">
                                            <span class="admin-meter__track">
                                                <span class="admin-meter__bar" style="width: {{ max(0, min(100, $skill->percentage)) }}%;"></span>
                                            </span>
                                            <span>{{ $skill->percentage }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">{{ $skill->sort_order }}</div>
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            <a href="{{ route('admin.skills.edit', $skill) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Edit {{ $skill->name }}" title="Edit">
                                                <i class="ri-edit-line" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="admin-inline-form" data-confirm="Hapus keahlian ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus {{ $skill->name }}" title="Hapus">
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
            @endif
        </section>
    </div>
@endsection
