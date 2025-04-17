@extends('admin.layouts.app')

@section('title', 'Courses')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Courses</h1>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Course
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            <tr>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->duration }}</td>
                                <td>${{ number_format($course->price, 2) }}</td>
                                <td>{{ ucfirst($course->level) }}</td>
                                <td>
                                    <span class="badge bg-{{ $course->is_active ? 'success' : 'danger' }}">
                                        {{ $course->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No courses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $courses->links() }}
    </div>
@endsection 