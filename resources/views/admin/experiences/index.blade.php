@extends('layouts.admin')

@section('title', 'Pengalaman')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Konten</p>
                <h1 class="admin-title">Pengalaman</h1>
                <p class="admin-lead">Atur riwayat PLK, organisasi, dan lomba yang tampil di bagian tentang saya.</p>
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.experiences.create') }}" class="admin-btn admin-btn--primary">
                    <i class="ri-add-line" aria-hidden="true"></i>
                    Pengalaman baru
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
                    <h2 class="admin-panel__title">Daftar pengalaman</h2>
                    <p>{{ $experiences->count() }} entri tersimpan</p>
                </div>
            </div>

            @if ($experiences->isEmpty())
                <div class="admin-empty">
                    <i class="ri-briefcase-line" aria-hidden="true"></i>
                    <strong>Belum ada pengalaman</strong>
                    <p>Tambahkan pengalaman PLK, organisasi, atau lomba untuk melengkapi profil.</p>
                    <a href="{{ route('admin.experiences.create') }}" class="admin-btn admin-btn--primary">
                        <i class="ri-add-line" aria-hidden="true"></i>
                        Tambah pengalaman
                    </a>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Pengalaman</th>
                                <th>Periode</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($experiences as $experience)
                                <tr>
                                    <td>
                                        <span class="admin-badge {{ $experience->category === 'plk' ? 'admin-badge--live' : '' }}">
                                            {{ ['plk' => 'PLK', 'organization' => 'Organisasi', 'competition' => 'Lomba'][$experience->category] ?? ucfirst($experience->category) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="admin-table__primary">{{ $experience->title }}</div>
                                        <div class="admin-table__meta">{{ $experience->organization }}{{ $experience->role ? ' · '.$experience->role : '' }}</div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">
                                            {{ $experience->start_date->format('M Y') }} — {{ $experience->end_date?->format('M Y') ?? 'Sekarang' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            <a href="{{ route('admin.experiences.edit', $experience) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Edit {{ $experience->title }}" title="Edit">
                                                <i class="ri-edit-line" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" class="admin-inline-form" data-confirm="Hapus pengalaman ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus {{ $experience->title }}" title="Hapus">
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
