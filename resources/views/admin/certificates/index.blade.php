@extends('layouts.admin')

@section('title', 'Sertifikat')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Konten</p>
                <h1 class="admin-title">Sertifikat</h1>
                <p class="admin-lead">Simpan sertifikat, prestasi, dan dokumentasi pendukung dalam satu tempat.</p>
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.certificates.create') }}" class="admin-btn admin-btn--primary">
                    <i class="ri-add-line" aria-hidden="true"></i>
                    Sertifikat baru
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
                    <h2 class="admin-panel__title">Daftar sertifikat</h2>
                    <p>{{ $certificates->count() }} sertifikat tersimpan</p>
                </div>
            </div>

            @if ($certificates->isEmpty())
                <div class="admin-empty">
                    <i class="ri-award-line" aria-hidden="true"></i>
                    <strong>Belum ada sertifikat</strong>
                    <p>Tambahkan sertifikat atau prestasi untuk memperkuat portofolio.</p>
                    <a href="{{ route('admin.certificates.create') }}" class="admin-btn admin-btn--primary">
                        <i class="ri-add-line" aria-hidden="true"></i>
                        Tambah sertifikat
                    </a>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Sertifikat</th>
                                <th>Tanggal</th>
                                <th>Dokumentasi</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($certificates as $certificate)
                                <tr>
                                    <td>
                                        <div class="admin-table__primary">{{ $certificate->title }}</div>
                                        @if ($certificate->description)
                                            <div class="admin-table__meta">{{ \Illuminate\Support\Str::limit($certificate->description, 90) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">{{ $certificate->date?->format('d M Y') ?? 'Belum diisi' }}</div>
                                    </td>
                                    <td>
                                        @if ($certificate->documentation)
                                            <a href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer" class="admin-file-link" style="margin-top: 0;">
                                                <i class="ri-file-line" aria-hidden="true"></i>
                                                Lihat file
                                            </a>
                                        @else
                                            <span class="admin-table__meta">Tidak ada file</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            <a href="{{ route('admin.certificates.show', $certificate) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Lihat {{ $certificate->title }}" title="Lihat">
                                                <i class="ri-eye-line" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('admin.certificates.edit', $certificate) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Edit {{ $certificate->title }}" title="Edit">
                                                <i class="ri-edit-line" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" class="admin-inline-form" data-confirm="Hapus sertifikat ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus {{ $certificate->title }}" title="Hapus">
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
