@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('styles')
    .dashboard {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 2rem;
    }
    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .card {
        background: var(--color-container);
        padding: 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
        color: var(--color-text);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s, border-color 0.2s;
        border: 1px solid transparent;
    }
    .card:hover { transform: translateY(-4px); border-color: var(--color-first); }
    .card-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 0.75rem;
        background: rgba(80, 200, 120, 0.15);
        color: var(--color-first);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    .card h3 { color: var(--color-title); margin-bottom: 0.25rem; font-size: 1rem; }
    .card p { font-size: 0.813rem; }
@endsection

@section('content')
    <div class="dashboard">
        <div class="cards">
            <a href="{{ route('admin.projects.index') }}" class="card">
                <div class="card-icon"><i class="ri-folder-line"></i></div>
                <div>
                    <h3>Manage Projects</h3>
                    <p>Create, edit, and delete portfolio projects</p>
                </div>
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="card"><div class="card-icon"><i class="ri-user-line"></i></div><div><h3>Profil</h3><p>Kelola informasi profil dan kontak</p></div></a>
            <a href="{{ route('admin.skills.index') }}" class="card"><div class="card-icon"><i class="ri-bar-chart-line"></i></div><div><h3>Keahlian</h3><p>Atur hard skill, soft skill, dan persentase</p></div></a>
            <a href="{{ route('admin.experiences.index') }}" class="card"><div class="card-icon"><i class="ri-briefcase-line"></i></div><div><h3>Pengalaman</h3><p>Kelola PLK, organisasi, dan lomba</p></div></a>
            <a href="{{ route('admin.certificates.index') }}" class="card"><div class="card-icon"><i class="ri-award-line"></i></div><div><h3>Sertifikat</h3><p>Tambah dan hapus sertifikat atau prestasi</p></div></a>
            <a href="{{ route('admin.messages.index') }}" class="card"><div class="card-icon"><i class="ri-mail-line"></i></div><div><h3>Pesan Kontak</h3><p>Tinjau pesan yang dikirim pengunjung</p></div></a>
            <a href="{{ route('admin.feedback.index') }}" class="card"><div class="card-icon"><i class="ri-chat-1-line"></i></div><div><h3>Kesan dan Pesan</h3><p>Tinjau masukan pengunjung</p></div></a>
            <a href="/" class="card">
                <div class="card-icon"><i class="ri-eye-line"></i></div>
                <div>
                    <h3>View Portfolio</h3>
                    <p>See your public portfolio site</p>
                </div>
            </a>
        </div>
    </div>
@endsection
