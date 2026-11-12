@extends('layouts.admin')

@section('title', $certificate->title . ' - Certificate Details')

@section('styles')
    .container { max-width: 640px; margin: 0 auto; padding: 2rem; }
    .back { display: inline-block; color: var(--color-text); text-decoration: none; margin-bottom: 1.5rem; }
    .card { background: var(--color-container); border-radius: 1rem; overflow: hidden; }
    .card-body { padding: 2rem; color: var(--color-text); }
    .card-body h1 { color: var(--color-title); margin-bottom: 1rem; }
    .card-body p { line-height: 1.7; white-space: pre-wrap; }
    .document { display: block; margin-top: 1.5rem; }
    .document img { max-width: 100%; max-height: 360px; object-fit: contain; }
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('admin.certificates.index') }}" class="back"><i class="ri-arrow-left-line"></i> Back to Certificates</a>
        <div class="card"><div class="card-body">
            <h1>{{ $certificate->title }}</h1>
            @if ($certificate->date)<p><strong>Date:</strong> {{ $certificate->date->format('F j, Y') }}</p>@endif
            @if ($certificate->description)<p>{{ $certificate->description }}</p>@endif
            @if ($certificate->documentation)
                <a class="document" href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer">
                    @if (in_array(strtolower(pathinfo($certificate->documentation, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ Storage::url($certificate->documentation) }}" alt="Documentation for {{ $certificate->title }}">
                    @else View PDF documentation @endif
                </a>
            @endif
        </div></div>
    </div>
@endsection
