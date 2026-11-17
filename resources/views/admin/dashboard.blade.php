@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="admin-page admin-dashboard">
        <header class="admin-page__head">
            <h1 class="admin-title">Selamat datang, {{ $firstName }}.</h1>
            <a href="{{ route('admin.projects.create') }}" class="admin-btn admin-btn--primary">
                Tambah proyek
            </a>
        </header>

        <section class="admin-overview" aria-label="Jumlah konten">
            <a href="{{ route('admin.projects.index') }}" class="admin-overview__link">
                <span>Proyek</span>
                <span class="admin-overview__count">{{ $counts['projects'] }}</span>
            </a>
            <a href="{{ route('admin.articles.index') }}" class="admin-overview__link">
                <span>Blog</span>
                <span class="admin-overview__count">{{ $counts['articles'] }}</span>
            </a>
            <a href="{{ route('admin.experiences.index') }}" class="admin-overview__link">
                <span>Pengalaman</span>
                <span class="admin-overview__count">{{ $counts['experiences'] }}</span>
            </a>
            <a href="{{ route('admin.skills.index') }}" class="admin-overview__link">
                <span>Keahlian</span>
                <span class="admin-overview__count">{{ $counts['skills'] }}</span>
            </a>
            <a href="{{ route('admin.certificates.index') }}" class="admin-overview__link">
                <span>Sertifikat</span>
                <span class="admin-overview__count">{{ $counts['certificates'] }}</span>
            </a>
            <a href="{{ route('admin.testimonials.index') }}" class="admin-overview__link">
                <span>Testimoni</span>
                <span class="admin-overview__count">{{ $counts['testimonials'] }}</span>
            </a>
        </section>
    </div>
@endsection
