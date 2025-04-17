@extends('admin.layouts.app')

@section('title', $quiz->title)

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>{{ $quiz->title }}</h2>
            <div>
                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this quiz?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>Description</h4>
                    <p>{{ $quiz->description }}</p>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Quiz Details</h5>
                            <ul class="list-unstyled">
                                <li><strong>Course:</strong> {{ $quiz->course->title }}</li>
                                <li><strong>Time Limit:</strong> {{ $quiz->time_limit ? $quiz->time_limit . ' minutes' : 'No limit' }}</li>
                                <li><strong>Passing Score:</strong> {{ $quiz->passing_score }}%</li>
                                <li>
                                    <strong>Status:</strong>
                                    <span class="badge bg-{{ $quiz->is_active ? 'success' : 'danger' }}">
                                        {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </li>
                                <li><strong>Created:</strong> {{ $quiz->created_at->format('M d, Y') }}</li>
                                <li><strong>Last Updated:</strong> {{ $quiz->updated_at->format('M d, Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Quizzes
        </a>
    </div>
@endsection 