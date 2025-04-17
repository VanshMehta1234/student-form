@extends('admin.layouts.app')

@section('title', $course->title)

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>{{ $course->title }}</h2>
            <div>
                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>Description</h4>
                    <p>{{ $course->description }}</p>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Course Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Duration:</strong> {{ $course->duration }}</li>
                                <li><strong>Price:</strong> ${{ number_format($course->price, 2) }}</li>
                                <li><strong>Level:</strong> {{ ucfirst($course->level) }}</li>
                                <li>
                                    <strong>Status:</strong>
                                    <span class="badge bg-{{ $course->is_active ? 'success' : 'danger' }}">
                                        {{ $course->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                                <li><strong>Created:</strong> {{ $course->created_at->format('M d, Y') }}</li>
                                <li><strong>Last Updated:</strong> {{ $course->updated_at->format('M d, Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h4>Quizzes</h4>
                @if($course->quizzes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Time Limit</th>
                                    <th>Passing Score</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->quizzes as $quiz)
                                    <tr>
                                        <td>{{ $quiz->title }}</td>
                                        <td>{{ $quiz->time_limit ? $quiz->time_limit . ' minutes' : 'No limit' }}</td>
                                        <td>{{ $quiz->passing_score }}%</td>
                                        <td>
                                            <span class="badge bg-{{ $quiz->is_active ? 'success' : 'danger' }}">
                                                {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No quizzes available for this course.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>
@endsection 