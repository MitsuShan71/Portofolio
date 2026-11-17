@extends('layouts.admin')

@section('title', 'Proyek')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Konten</p>
                <h1 class="admin-title">Proyek</h1>
                <p class="admin-lead">Kelola karya yang tampil di portofolio. Setiap proyek membutuhkan gambar utama sebagai pratinjau.</p>
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn--primary">
                    <i class="ri-add-line" aria-hidden="true"></i>
                    Proyek baru
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
                    <h2 class="admin-panel__title">Daftar proyek</h2>
                    <p>{{ $projects->count() }} proyek tersimpan</p>
                </div>
            </div>

            @if ($projects->isEmpty())
                <div class="admin-empty">
                    <i class="ri-folder-open-line" aria-hidden="true"></i>
                    <strong>Belum ada proyek</strong>
                    <p>Tambahkan karya pertama supaya muncul di bagian proyek halaman publik.</p>
                    <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn--primary">
                        <i class="ri-add-line" aria-hidden="true"></i>
                        Tambah proyek
                    </a>
                </div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Proyek</th>
                                <th>Deskripsi</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            @if ($project->image)
                                                <img src="{{ Storage::url($project->image) }}" alt="" class="admin-table__thumb">
                                            @else
                                                <span class="admin-table__placeholder"><i class="ri-image-line" aria-hidden="true"></i></span>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.projects.show', $project) }}" class="admin-table__primary">{{ $project->title }}</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__meta" style="max-width: 30rem;">
                                            {{ $project->description ? \Illuminate\Support\Str::limit($project->description, 110) : 'Belum ada deskripsi.' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-table__actions">
                                            <a href="{{ route('admin.projects.show', $project) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Lihat {{ $project->title }}" title="Lihat">
                                                <i class="ri-eye-line" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn--sm admin-btn--ghost admin-btn--icon" aria-label="Edit {{ $project->title }}" title="Edit">
                                                <i class="ri-edit-line" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="admin-inline-form" data-confirm="Hapus proyek ini?">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-btn admin-btn--sm admin-btn--danger admin-btn--icon" aria-label="Hapus {{ $project->title }}" title="Hapus">
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
