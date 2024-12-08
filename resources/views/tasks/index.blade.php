<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">Task Management</h1>

        <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Task Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Task Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Add Task</button>
        </form>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($tasks->isEmpty())
            <div class="alert alert-info">
                Tugas Kosong
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center bg-dark text-light">Name</th>
                        <th class="text-center bg-dark text-light">Description</th>
                        <th class="text-center bg-dark text-light">Status</th>
                        <th class="text-center bg-dark text-light">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td class="align-middle">{{ $task->name }}</td>
                            <td class="align-middle">{{ $task->description }}</td>
                            <td class="align-middle text-center">
                                <span class="badge {{ $task->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                {{-- ['id' $task->id] bisa juga gini --}}
                                <div class="d-flex gap-2 justify-content-center flex-wrap">
                                    <a href="{{ route('tasks.edit', $task->id) }}"
                                        class="btn btn-warning btn-sm mb-2">Edit</a>
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-2">Delete</button>
                                    </form>
                                    @if ($task->status == 'pending')
                                        <form action="{{ route('tasks.complete', $task->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">Mark Done</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>

</html>
