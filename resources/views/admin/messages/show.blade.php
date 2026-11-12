@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)

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
            <h1>Contact Message</h1>
            <div class="meta">
                <div><strong>From:</strong> {{ $message->name }}</div>
                <div><strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></div>
                <div><strong>Received:</strong> {{ $message->created_at->format('Y-m-d H:i') }}</div>
            </div>
            <div class="message">{{ $message->message }}</div>
            <div class="actions">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Back to Messages</a>
                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
