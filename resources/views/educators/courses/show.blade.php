@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Course Details') }}</span>
                    <div>
                        <a href="{{ route('educator.courses.edit', $course) }}" class="btn btn-primary btn-sm">Edit Course</a>
                        <a href="{{ route('educator.courses.index') }}" class="btn btn-secondary btn-sm">Back to Courses</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2>{{ $course->title }}</h2>
                            <p class="text-muted">
                                <span class="badge bg-{{ $course->is_active ? 'success' : 'danger' }}">
                                    {{ $course->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="ms-2">Level: {{ ucfirst($course->level) }}</span>
                                <span class="ms-2">Duration: {{ $course->duration }}</span>
                                <span class="ms-2">Price: ${{ number_format($course->price, 2) }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>Description</h4>
                            <p>{{ $course->description }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
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
                                                        @if($quiz->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('educator.quizzes.show', $quiz) }}" class="btn btn-info btn-sm">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    No quizzes have been created for this course yet.
                                </div>
                            @endif
                            <a href="{{ route('educator.quizzes.create', ['course_id' => $course->id]) }}" class="btn btn-primary mt-3">Create New Quiz</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('educator.courses.destroy', $course) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course? This will also delete all associated quizzes.')">
                                    {{ __('Delete Course') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 