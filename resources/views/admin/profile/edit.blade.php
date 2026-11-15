@extends('layouts.admin')

@section('title', 'Profil')

@section('content')
    <div class="admin-page">
        <header class="admin-page__head">
            <div>
                <p class="admin-eyebrow">Pengaturan</p>
                <h1 class="admin-title">Profil portofolio</h1>
                <p class="admin-lead">Perbarui identitas, ringkasan, minat, dan berkas CV yang tampil di halaman utama.</p>
            </div>
            <div class="admin-actions">
                <a href="{{ route('home') }}" class="admin-btn admin-btn--ghost">
                    <i class="ri-eye-line" aria-hidden="true"></i>
                    Lihat portofolio
                </a>
            </div>
        </header>

        @if (session('success'))
            <div class="admin-alert" role="status">
                <i class="ri-checkbox-circle-line" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="admin-alert admin-alert--danger" role="alert">
                <i class="ri-error-warning-line" aria-hidden="true"></i>
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <section class="admin-panel admin-form-panel">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="admin-form">
                @csrf
                @method('PATCH')

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="full_name" class="admin-label">Nama lengkap</label>
                        <input id="full_name" name="full_name" type="text" maxlength="255" value="{{ old('full_name', $profile->full_name) }}" class="admin-input">
                        @error('full_name') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="class_name" class="admin-label">Kelas</label>
                        <input id="class_name" name="class_name" type="text" maxlength="255" value="{{ old('class_name', $profile->class_name) }}" class="admin-input">
                        @error('class_name') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="competency" class="admin-label">Kompetensi</label>
                        <input id="competency" name="competency" type="text" maxlength="255" value="{{ old('competency', $profile->competency) }}" class="admin-input">
                        @error('competency') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="email" class="admin-label">Email</label>
                        <input id="email" name="email" type="email" maxlength="255" value="{{ old('email', $profile->email) }}" class="admin-input">
                        @error('email') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="github_url" class="admin-label">URL GitHub</label>
                        <input id="github_url" name="github_url" type="url" maxlength="255" value="{{ old('github_url', $profile->github_url) }}" class="admin-input">
                        @error('github_url') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="instagram_url" class="admin-label">URL Instagram</label>
                        <input id="instagram_url" name="instagram_url" type="url" maxlength="255" value="{{ old('instagram_url', $profile->instagram_url) }}" class="admin-input">
                        @error('instagram_url') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-field">
                    <label for="summary" class="admin-label">Ringkasan</label>
                    <textarea id="summary" name="summary" class="admin-textarea">{{ old('summary', $profile->summary) }}</textarea>
                    @error('summary') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="bio" class="admin-label">Biografi</label>
                    <textarea id="bio" name="bio" class="admin-textarea">{{ old('bio', $profile->bio) }}</textarea>
                    @error('bio') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="education" class="admin-label">Pendidikan</label>
                    <textarea id="education" name="education" class="admin-textarea">{{ old('education', $profile->education) }}</textarea>
                    <span class="admin-hint">Satu item per baris.</span>
                    @error('education') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="technology_interests" class="admin-label">Minat dan fokus teknologi</label>
                    <textarea id="technology_interests" name="technology_interests" class="admin-textarea">{{ old('technology_interests', $profile->technology_interests) }}</textarea>
                    @error('technology_interests') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-field">
                    <label for="career_goal" class="admin-label">Tujuan karier</label>
                    <textarea id="career_goal" name="career_goal" class="admin-textarea">{{ old('career_goal', $profile->career_goal) }}</textarea>
                    @error('career_goal') <span class="admin-error">{{ $message }}</span> @enderror
                </div>

                <div class="admin-form__grid">
                    <div class="admin-field">
                        <label for="profile_image" class="admin-label">Foto profil</label>
                        <input id="profile_image" name="profile_image" type="file" accept="image/jpeg,image/png,image/webp" class="admin-input">
                        <span class="admin-hint">JPG, PNG, atau WebP. Maksimal 5 MB.</span>
                        @if ($profile->profile_image)
                            <img class="admin-preview admin-preview--portrait" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profile->profile_image) }}" alt="Foto profil saat ini">
                        @endif
                        @error('profile_image') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="admin-field">
                        <label for="resume_file" class="admin-label">CV</label>
                        <input id="resume_file" name="resume_file" type="file" accept="application/pdf" class="admin-input">
                        <span class="admin-hint">PDF dengan ukuran maksimal 10 MB.</span>
                        <a href="{{ $profile->resume_file ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->resume_file) : asset('cv-shan-favian-efendy.pdf') }}" target="_blank" rel="noopener noreferrer" class="admin-file-link">
                            <i class="ri-file-pdf-line" aria-hidden="true"></i>
                            Lihat CV saat ini
                        </a>
                        @error('resume_file') <span class="admin-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="admin-form__actions">
                    <button type="submit" class="admin-btn admin-btn--primary">
                        <i class="ri-save-line" aria-hidden="true"></i>
                        Simpan profil
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
