@extends('layouts.admin')

@section('title', 'Testimoni')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Interaksi</p>
                <h1 class="admin-title">Testimoni</h1>
                <p class="admin-lead">Pesan dan rating yang dikirim pengunjung melalui form Testimoni.</p>
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
                    <h2 class="admin-panel__title">Daftar testimoni</h2>
                    <p>{{ $feedback->total() }} testimoni diterima</p>
                </div>
            </div>

            @if ($feedback->isEmpty())
                <div class="admin-empty">
                    <i class="ri-chat-quote-line"></i>
                    <strong>Belum ada testimoni</strong>
                    <p>Testimoni yang dikirim dari halaman portofolio akan muncul di sini.</p>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Pengunjung</th>
                                <th>Rating</th>
                                <th>Testimoni</th>
                                <th>Diterima</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedback as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.feedback.show', $item) }}" class="admin-table__primary">{{ $item->name }}</a>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">{{ $item->rating ? $item->rating . ' / 5' : '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta" style="max-width: 30rem;">
                                            {{ \Illuminate\Support\Str::limit($item->message, 130) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">{{ $item->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            <a href="{{ route('admin.feedback.show', $item) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Baca testimoni dari {{ $item->name }}" title="Baca">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <form action="{{ route('admin.feedback.destroy', $item) }}" method="POST" class="admin-inline-form" data-confirm="Hapus testimoni ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus testimoni dari {{ $item->name }}" title="Hapus">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $feedback->links('pagination.admin') }}
            @endif
        </section>
    </div>
@endsection
