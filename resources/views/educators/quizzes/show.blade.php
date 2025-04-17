@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Quiz Details') }}</span>
                    <div>
                        <a href="{{ route('educator.quizzes.edit', $quiz) }}" class="btn btn-primary btn-sm">Edit Quiz</a>
                        <a href="{{ route('educator.quizzes.index') }}" class="btn btn-secondary btn-sm">Back to Quizzes</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h2>{{ $quiz->title }}</h2>
                            <p class="text-muted">
                                <span class="badge bg-{{ $quiz->is_active ? 'success' : 'danger' }}">
                                    {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="ms-2">Course: {{ $quiz->course->title }}</span>
                                <span class="ms-2">Time Limit: {{ $quiz->time_limit ? $quiz->time_limit . ' minutes' : 'No limit' }}</span>
                                <span class="ms-2">Passing Score: {{ $quiz->passing_score }}%</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>Description</h4>
                            <p>{{ $quiz->description }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('educator.quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this quiz?')">
                                    {{ __('Delete Quiz') }}
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