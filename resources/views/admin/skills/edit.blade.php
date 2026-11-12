@extends('layouts.admin')
@section('title', 'Edit Skill')
@section('content')
<div class="container" style="max-width:480px;margin:auto;padding:2rem">
    <h1>Edit Skill</h1>
    <form action="{{ route('admin.skills.update', $skill) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div><label for="name">Name</label><input id="name" name="name" value="{{ old('name', $skill->name) }}" required>@error('name')<p>{{ $message }}</p>@enderror</div>
        <div><label for="category">Category</label><select id="category" name="category" required><option value="hard" @selected(old('category', $skill->category) === 'hard')>Hard</option><option value="soft" @selected(old('category', $skill->category) === 'soft')>Soft</option></select>@error('category')<p>{{ $message }}</p>@enderror</div>
        <div><label for="percentage">Percentage (0–100)</label><input type="number" id="percentage" name="percentage" min="0" max="100" step="1" value="{{ old('percentage', $skill->percentage) }}" required>@error('percentage')<p>{{ $message }}</p>@enderror</div>
        <div><label for="icon">Icon path or class</label><input id="icon" name="icon" value="{{ old('icon', $skill->icon) }}">@error('icon')<p>{{ $message }}</p>@enderror</div>
        <div><label for="icon_image">Or upload icon image</label><input type="file" id="icon_image" name="icon_image" accept="image/*">@error('icon_image')<p>{{ $message }}</p>@enderror</div>
        <div><label for="sort_order">Sort order</label><input type="number" id="sort_order" name="sort_order" min="0" step="1" value="{{ old('sort_order', $skill->sort_order) }}">@error('sort_order')<p>{{ $message }}</p>@enderror</div>
        <button type="submit">Update</button> <a href="{{ route('admin.skills.index') }}">Cancel</a>
    </form>
</div>
@endsection
