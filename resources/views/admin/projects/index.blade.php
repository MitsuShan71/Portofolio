<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :root {
            --color-body: #2b2e3b;
            --color-container: #21232c;
            --color-title: #f1f2f3;
            --color-text: #9fa1ad;
            --color-first: #50C878;
            --color-first-alt: #50C878;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--color-body);
            color: var(--color-text);
            padding: 2rem;
        }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: var(--color-title); margin-bottom: 1.5rem; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 0.938rem;
        }
        .btn-primary { background: var(--color-first); color: var(--color-title); }
        .btn-danger { background: #dc3545; color: #fff; }
        .btn-edit { background: #ffc107; color: #000; }
        .mb-3 { margin-bottom: 1.5rem; }
        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            background: #198754;
            color: #fff;
        }
        .table-wrapper {
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid var(--color-title);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--color-container);
        }
        th, td {
            padding: 1rem;
            text-align: left;
        }
        th { color: var(--color-title); font-weight: 600; background: #1a1c26; }
        td { color: var(--color-text); }
        .actions { display: flex; gap: 0.5rem; }
        .actions .btn { padding: 0.5rem 0.75rem; font-size: 0.813rem; }
        .project-img { width: 40px; height: 28px; object-fit: cover; border-radius: 4px; }
        form.inline { display: inline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="mb-3" style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Manage Projects</h1>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                <i class="ri-add-line"></i> New Project
            </a>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>
                            @if ($project->image)
                                <img src="{{ Storage::url($project->image) }}" alt="" class="project-img">
                            @else
                                <span style="color: #666; font-size: 0.813rem;">No image</span>
                            @endif
                        </td>
                        <td>{{ $project->title }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-edit">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 2rem; color: #666;">No projects yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</body>
</html>
