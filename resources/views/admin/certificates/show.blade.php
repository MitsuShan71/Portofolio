@extends('layouts.admin')

@section('title', $certificate->title)

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.certificates.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke sertifikat
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Detail sertifikat</p>
                <h1 class="admin-title">{{ $certificate->title }}</h1>
                @if ($certificate->description)
                    <p class="admin-lead">{{ $certificate->description }}</p>
                @endif
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.certificates.edit', $certificate) }}" class="admin-btn admin-btn--primary">
                    <i class="ri-edit-line" aria-hidden="true"></i>
                    Edit sertifikat
                </a>
            </div>
        </header>

        <article class="admin-detail-card">
            <div class="admin-detail-card__head">
                <h2 class="admin-panel__title">Informasi sertifikat</h2>
                <p>Dokumentasi dan detail pencapaian.</p>
            </div>
            <div class="admin-detail-card__body">
                <div class="admin-meta-grid">
                    <div class="admin-meta-item">
                        <span>Tanggal</span>
                        <strong>{{ $certificate->date?->format('d M Y') ?? 'Belum diisi' }}</strong>
                    </div>
                    <div class="admin-meta-item">
                        <span>Dokumentasi</span>
                        <strong>{{ $certificate->documentation ? 'Tersedia' : 'Tidak ada file' }}</strong>
                    </div>
                </div>

                @if ($certificate->description)
                    <div class="admin-message-box">{{ $certificate->description }}</div>
                @endif

                @if ($certificate->documentation)
                    @if (in_array(strtolower(pathinfo($certificate->documentation, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <a class="admin-document" href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ Storage::url($certificate->documentation) }}" alt="Dokumentasi {{ $certificate->title }}">
                        </a>
                    @else
                        <a href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer" class="admin-btn admin-btn--ghost" style="margin-top: 1.2rem;">
                            <i class="ri-file-pdf-line" aria-hidden="true"></i>
                            Buka dokumentasi PDF
                        </a>
                    @endif
                @endif

                <div class="admin-detail__actions">
                    <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" class="admin-inline-form" data-confirm="Hapus sertifikat ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn--danger">
                            <i class="ri-delete-bin-line" aria-hidden="true"></i>
                            Hapus sertifikat
                        </button>
                    </form>
                </div>
            </div>
        </article>
    </div>
@endsection
