@extends('layouts.admin')

@section('title', 'Pesan kontak')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Interaksi</p>
                <h1 class="admin-title">Pesan kontak</h1>
                <p class="admin-lead">Pesan yang dikirim pengunjung lewat formulir kontak di halaman portofolio.</p>
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
                    <h2 class="admin-panel__title">Kotak masuk</h2>
                    <p>{{ $messages->total() }} pesan diterima</p>
                </div>
            </div>

            @if ($messages->isEmpty())
                <div class="admin-empty">
                    <i class="ri-mail-open-line" aria-hidden="true"></i>
                    <strong>Kotak masuk masih kosong</strong>
                    <p>Pesan dari formulir kontak akan muncul di sini.</p>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Pesan</th>
                                <th>Diterima</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.messages.show', $message) }}" class="admin-table__primary">{{ $message->name }}</a>
                                        <div class="admin-table__meta">{{ $message->email }}</div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta" style="max-width: 28rem;">
                                            {{ \Illuminate\Support\Str::limit($message->message, 120) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">{{ $message->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            <a href="{{ route('admin.messages.show', $message) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Baca pesan dari {{ $message->name }}" title="Baca">
                                                <i class="ri-eye-line" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="admin-inline-form" data-confirm="Hapus pesan ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus pesan dari {{ $message->name }}" title="Hapus">
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

                {{ $messages->links('pagination.admin') }}
            @endif
        </section>
    </div>
@endsection
