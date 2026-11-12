@extends('layouts.admin')

@section('title', 'Manage Certificates')

@section('styles')
    .container { max-width: 800px; margin: 0 auto; padding: 2rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    .btn-primary { background: var(--color-first); color: var(--color-title); }
    .btn-edit { background: #ffc107; color: #000; }
    .btn-danger { background: #dc3545; color: #fff; }
    .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; background: #198754; color: #fff; }
    .table-wrapper { border-radius: 0.5rem; overflow: hidden; border: 1px solid var(--color-title); }
    table { width: 100%; border-collapse: collapse; background: var(--color-container); }
    th, td { padding: 1rem; text-align: left; }
    th { color: var(--color-title); font-weight: 600; background: #1a1c26; }
    td { color: var(--color-text); }
    .actions { display: flex; gap: 0.5rem; }
    form.inline { display: inline; }
@endsection

@section('content')
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
            <h1>Manage Certificates &amp; Achievements</h1>
            <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary"><i class="ri-add-line"></i> New Certificate</a>
        </div>
        @if (session('success')) <div class="alert">{{ session('success') }}</div> @endif
        <div class="table-wrapper">
            <table>
                <thead><tr><th>Title</th><th>Date</th><th>Documentation</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($certificates as $certificate)
                        <tr>
                            <td>{{ $certificate->title }}</td>
                            <td>{{ $certificate->date?->format('Y-m-d') ?? '—' }}</td>
                            <td>@if ($certificate->documentation)<a href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer">View file</a>@else — @endif</td>
                            <td class="actions">
                                <a href="{{ route('admin.certificates.show', $certificate) }}" class="btn btn-primary" aria-label="View">View</a>
                                <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-edit" aria-label="Edit"><i class="ri-edit-line"></i></a>
                                <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" class="inline" onsubmit="return confirm('Delete this certificate?')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger" aria-label="Delete"><i class="ri-delete-bin-line"></i></button></form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:2rem;color:#666">No certificates yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
