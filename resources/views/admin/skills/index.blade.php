@extends('layouts.admin')

@section('title', 'Manage Skills')

@section('content')
<div class="container" style="padding:2rem">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <h1>Manage Skills</h1><a href="{{ route('admin.skills.create') }}">Add Skill</a>
    </div>
    @if (session('success')) <p>{{ session('success') }}</p> @endif
    <table style="width:100%;text-align:left">
        <thead><tr><th>Name</th><th>Category</th><th>Percentage</th><th>Icon</th><th>Order</th><th>Actions</th></tr></thead>
        <tbody>
        @forelse ($skills as $skill)
            <tr>
                <td>{{ $skill->name }}</td><td>{{ ucfirst($skill->category) }}</td><td>{{ $skill->percentage }}%</td>
                <td>{{ $skill->icon }}</td><td>{{ $skill->sort_order }}</td>
                <td><a href="{{ route('admin.skills.edit', $skill) }}">Edit</a>
                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this skill?')">@csrf @method('DELETE')<button type="submit">Delete</button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No skills yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
