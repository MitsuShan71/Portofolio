@extends('layouts.admin')

@section('title', $project->title)

@section('content')
    <div class="admin-page">
        <a href="{{ route('admin.projects.index') }}" class="admin-back">
            <i class="ri-arrow-left-line" aria-hidden="true"></i>
            Kembali ke proyek
        </a>

        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Detail proyek</p>
                <h1 class="admin-title">{{ $project->title }}</h1>
                @if ($project->description)
                    <p class="admin-lead">{{ $project->description }}</p>
                @endif
            </div>
            <div class="admin-actions">
                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-btn admin-btn--primary">
                    <i class="ri-edit-line" aria-hidden="true"></i>
                    Edit proyek
                </a>
            </div>
        </header>

        <article class="admin-detail">
            <div class="admin-detail__media">
                @if ($project->image)
                    <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}">
                @else
                    <div class="admin-detail__placeholder">
                        <i class="ri-image-line" aria-hidden="true"></i>
                    </div>
                @endif
            </div>
            <div class="admin-detail__body">
                <h2>Informasi proyek</h2>
                <div class="admin-detail__meta">
                    <span class="admin-badge admin-badge--live">Proyek</span>
                    @if ($project->technologies)
                        <span>{{ $project->technologies }}</span>
                    @endif
                </div>

                @foreach ([
                    'problem_solved' => 'Masalah yang diselesaikan',
                    'objective' => 'Tujuan proyek',
                    'technologies' => 'Teknologi yang digunakan',
                    'role' => 'Peran',
                    'features' => 'Fitur utama',
                    'process_documentation' => 'Dokumentasi proses',
                    'user_feedback' => 'Umpan balik pengguna',
                    'details' => 'Detail tambahan',
                ] as $field => $label)
                    @if ($project->{$field})
                        <div class="admin-detail__field">
                            <span class="admin-detail__label">{{ $label }}</span>
                            <div class="admin-detail__value">{{ $project->{$field} }}</div>
                        </div>
                    @endif
                @endforeach

                <div class="admin-detail__actions">
                    @if ($project->demo_link)
                        <a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="admin-btn admin-btn--primary">
                            <i class="ri-external-link-line" aria-hidden="true"></i>
                            Buka demo
                        </a>
                    @endif
                    @if ($project->github_link)
                        <a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="admin-btn admin-btn--ghost">
                            <i class="ri-github-line" aria-hidden="true"></i>
                            Lihat sumber
                        </a>
                    @endif
                    @if ($project->link)
                        <a href="{{ $project->link }}" target="_blank" rel="noopener noreferrer" class="admin-btn admin-btn--ghost">
                            <i class="ri-link" aria-hidden="true"></i>
                            Tautan tambahan
                        </a>
                    @endif
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="admin-inline-form" data-confirm="Hapus proyek ini?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn admin-btn--danger">
                            <i class="ri-delete-bin-line" aria-hidden="true"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </article>
    </div>
@endsection
