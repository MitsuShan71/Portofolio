@extends('layouts.admin')

@section('title', 'Kesan & pesan')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Interaksi</p>
                <h1 class="admin-title">Kesan & pesan</h1>
                <p class="admin-lead">Masukan dan kesan dari pengunjung yang mengisi formulir di halaman portofolio.</p>
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
                    <h2 class="admin-panel__title">Daftar masukan</h2>
                    <p>{{ $feedback->total() }} masukan diterima</p>
                </div>
            </div>

            @if ($feedback->isEmpty())
                <div class="admin-empty">
                    <i class="ri-chat-1-line" aria-hidden="true"></i>
                    <strong>Belum ada masukan</strong>
                    <p>Kesan dan pesan dari pengunjung akan muncul di sini.</p>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Pengunjung</th>
                                <th>Masukan</th>
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
                                        <div class="admin-table__meta" style="max-width: 30rem;">
                                            {{ \Illuminate\Support\Str::limit($item->message, 130) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta">{{ $item->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            <a href="{{ route('admin.feedback.show', $item) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Baca masukan dari {{ $item->name }}" title="Baca">
                                                <i class="ri-eye-line" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.feedback.destroy', $item) }}" method="POST" class="admin-inline-form" data-confirm="Hapus masukan ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus masukan dari {{ $item->name }}" title="Hapus">
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

                {{ $feedback->links('pagination.admin') }}
            @endif
        </section>
    </div>
@endsection
