@extends('layouts.admin')

@section('title', 'Masukan dari ' . $feedback->name)

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.feedback.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke kesan & pesan
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Kesan & pesan</p>
                <h1 class="admin-title">Masukan dari {{ $feedback->name }}</h1>
                <p class="admin-lead">Diterima {{ $feedback->created_at->format('d M Y, H:i') }}.</p>
            </div>
        </header>

        <article class="admin-detail-card">
            <div class="admin-detail-card__head">
                <h2 class="admin-panel__title">Detail masukan</h2>
                <p>Kesan dan pesan yang dikirim pengunjung.</p>
            </div>
            <div class="admin-detail-card__body">
                <div class="admin-meta-grid">
                    <div class="admin-meta-item">
                        <span>Nama</span>
                        <strong>{{ $feedback->name }}</strong>
                    </div>
                    <div class="admin-meta-item">
                        <span>Diterima</span>
                        <strong>{{ $feedback->created_at->format('d M Y, H:i') }}</strong>
                    </div>
                </div>

                <div class="admin-message-box">{{ $feedback->message }}</div>

                <div class="admin-detail__actions">
                    <a href="{{ route('admin.feedback.index') }}" class="admin-btn admin-btn--ghost">
                        <i class="ri-arrow-left-line" aria-hidden="true"></i>
                        Kembali
                    </a>
                    <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" class="admin-inline-form" data-confirm="Hapus masukan ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn--danger">
                            <i class="ri-delete-bin-line" aria-hidden="true"></i>
                            Hapus masukan
                        </button>
                    </form>
                </div>
            </div>
        </article>
    </div>
@endsection
