@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('styles')
    .container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .alert { padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; background: #198754; color: #fff; }
    .table-wrapper { border-radius: 0.5rem; overflow-x: auto; border: 1px solid var(--color-title); }
    table { width: 100%; border-collapse: collapse; background: var(--color-container); }
    th, td { padding: 1rem; text-align: left; }
    th { color: var(--color-title); font-weight: 600; background: #1a1c26; }
    td { color: var(--color-text); }
    .actions { display: flex; gap: 0.5rem; align-items: center; }
    .btn { display: inline-flex; padding: 0.5rem 0.75rem; border: 0; border-radius: 0.5rem; text-decoration: none; cursor: pointer; font-weight: 600; }
    .btn-view { background: var(--color-first); color: #101510; }
    .btn-danger { background: #dc3545; color: #fff; }
    form.inline { display: inline; }
    .pagination { margin-top: 1rem; }
@endsection

@section('content')
    <div class="container">
        <h1>Contact Messages</h1>
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>Name</th><th>Email</th><th>Message</th><th>Received</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($message->message, 100) }}</td>
                            <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-view">View</a>
                                <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#666;">No messages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $messages->links() }}</div>
    </div>
@endsection
