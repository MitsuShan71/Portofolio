@extends('layouts.admin')

@section('title', 'Feedback from ' . $feedback->name)

@section('styles')
    .container { max-width: 800px; margin: 0 auto; padding: 2rem; }
    .card { background: var(--color-container); border: 1px solid #3a3d4a; border-radius: 0.5rem; padding: 1.5rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .meta { margin-bottom: 1rem; line-height: 1.7; }
    .meta strong { color: var(--color-title); }
    .message { white-space: pre-wrap; line-height: 1.7; overflow-wrap: anywhere; }
    .actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; align-items: center; }
    .btn { display: inline-flex; padding: 0.65rem 1rem; border: 0; border-radius: 0.5rem; text-decoration: none; cursor: pointer; font-weight: 600; }
    .btn-secondary { background: #3a3d4a; color: var(--color-title); }
    .btn-danger { background: #dc3545; color: #fff; }
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <h1>Feedback</h1>
            <div class="meta">
                <div><strong>From:</strong> {{ $feedback->name }}</div>
                <div><strong>Received:</strong> {{ $feedback->created_at->format('Y-m-d H:i') }}</div>
            </div>
            <div class="message">{{ $feedback->message }}</div>
            <div class="actions">
                <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">Back to Feedback</a>
                <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" onsubmit="return confirm('Delete this feedback?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
