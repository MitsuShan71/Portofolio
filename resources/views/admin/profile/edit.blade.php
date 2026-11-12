@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('styles')
    .profile-form { max-width: 900px; margin: 0 auto; padding: 2rem; color: var(--color-text); }
    .profile-form h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .field { margin-bottom: 1.25rem; }
    .field label { display: block; margin-bottom: .4rem; color: var(--color-title); font-weight: 600; }
    .field input, .field textarea { width: 100%; padding: .75rem; border: 1px solid #777; border-radius: .4rem; background: var(--color-container); color: var(--color-text); }
    .field textarea { min-height: 7rem; resize: vertical; }
    .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 0 1rem; }
    .btn { padding: .7rem 1rem; border: 0; border-radius: .4rem; background: var(--color-first); color: var(--color-title); font-weight: 600; cursor: pointer; }
    .alert { padding: 1rem; border-radius: .5rem; margin-bottom: 1.25rem; background: #198754; color: white; }
    .errors { margin-bottom: 1rem; color: #dc3545; }
    .current-image { display: block; max-width: 180px; max-height: 180px; object-fit: cover; margin: .75rem 0; }
@endsection

@section('content')
    <main class="profile-form">
        <h1>Edit Portfolio Profile</h1>
        @if (session('success')) <div class="alert">{{ session('success') }}</div> @endif
        @if ($errors->any())
            <div class="errors" role="alert"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-grid">
                <div class="field"><label for="full_name">Full name</label><input id="full_name" name="full_name" type="text" maxlength="255" value="{{ old('full_name', $profile->full_name) }}"></div>
                <div class="field"><label for="class_name">Class</label><input id="class_name" name="class_name" type="text" maxlength="255" value="{{ old('class_name', $profile->class_name) }}"></div>
                <div class="field"><label for="competency">Competency / expertise</label><input id="competency" name="competency" type="text" maxlength="255" value="{{ old('competency', $profile->competency) }}"></div>
                <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" maxlength="255" value="{{ old('email', $profile->email) }}"></div>
                <div class="field"><label for="github_url">GitHub URL</label><input id="github_url" name="github_url" type="url" maxlength="255" value="{{ old('github_url', $profile->github_url) }}"></div>
                <div class="field"><label for="instagram_url">Instagram URL</label><input id="instagram_url" name="instagram_url" type="url" maxlength="255" value="{{ old('instagram_url', $profile->instagram_url) }}"></div>
            </div>
            <div class="field"><label for="summary">Summary</label><textarea id="summary" name="summary">{{ old('summary', $profile->summary) }}</textarea></div>
            <div class="field"><label for="bio">Biography</label><textarea id="bio" name="bio">{{ old('bio', $profile->bio) }}</textarea></div>
            <div class="field"><label for="education">Education (one item per line)</label><textarea id="education" name="education">{{ old('education', $profile->education) }}</textarea></div>
            <div class="field"><label for="career_goal">Career goals</label><textarea id="career_goal" name="career_goal">{{ old('career_goal', $profile->career_goal) }}</textarea></div>
            <div class="field">
                <label for="profile_image">Profile image (JPG, PNG, or WebP; max 5 MB)</label>
                <input id="profile_image" name="profile_image" type="file" accept="image/jpeg,image/png,image/webp">
                @if ($profile->profile_image)
                    <img class="current-image" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($profile->profile_image) }}" alt="Current profile image">
                @endif
            </div>
            <div class="field">
                <label for="resume_file">CV (PDF; max 10 MB)</label>
                <input id="resume_file" name="resume_file" type="file" accept="application/pdf">
                <p>CV saat ini: <a href="{{ $profile->resume_file ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->resume_file) : asset('cv-shan-favian-efendy.pdf') }}" target="_blank" rel="noopener noreferrer">Lihat CV</a></p>
            </div>
            <button class="btn" type="submit">Save profile</button>
        </form>
    </main>
@endsection
