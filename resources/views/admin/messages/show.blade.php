@extends('layouts.admin')

@section('title', 'Pesan dari ' . $message->name)

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.messages.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke pesan kontak
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Pesan kontak</p>
                <h1 class="admin-title">Pesan dari {{ $message->name }}</h1>
                <p class="admin-lead">Diterima {{ $message->created_at->format('d M Y, H:i') }}.</p>
            </div>
            <div class="admin-actions">
                <a href="mailto:{{ $message->email }}" class="admin-btn admin-btn--primary">
                    <i class="ri-mail-send-line" aria-hidden="true"></i>
                    Balas email
                </a>
            </div>
        </header>

        <article class="admin-detail-card">
            <div class="admin-detail-card__head">
                <h2 class="admin-panel__title">Detail pesan</h2>
                <p>Kirim balasan langsung ke alamat email pengirim.</p>
            </div>
            <div class="admin-detail-card__body">
                <div class="admin-meta-grid">
                    <div class="admin-meta-item">
                        <span>Nama</span>
                        <strong>{{ $message->name }}</strong>
                    </div>
                    <div class="admin-meta-item">
                        <span>Email</span>
                        <strong><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></strong>
                    </div>
                    <div class="admin-meta-item">
                        <span>Diterima</span>
                        <strong>{{ $message->created_at->format('d M Y, H:i') }}</strong>
                    </div>
                </div>

                <div class="admin-message-box">{{ $message->message }}</div>

                <div class="admin-detail__actions">
                    <a href="{{ route('admin.messages.index') }}" class="admin-btn admin-btn--ghost">
                        <i class="ri-arrow-left-line" aria-hidden="true"></i>
                        Kembali
                    </a>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="admin-inline-form" data-confirm="Hapus pesan ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn--danger">
                            <i class="ri-delete-bin-line" aria-hidden="true"></i>
                            Hapus pesan
                        </button>
                    </form>
                </div>
            </div>
        </article>
    </div>
@endsection
