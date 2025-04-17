@extends('admin.layouts.app')

@section('title', 'Create Quiz')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Create Quiz</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.quizzes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-select @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                        <option value="">Select Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="time_limit" class="form-label">Time Limit (minutes)</label>
                    <input type="number" class="form-control @error('time_limit') is-invalid @enderror" id="time_limit" name="time_limit" value="{{ old('time_limit') }}" min="1">
                    <small class="text-muted">Leave empty for no time limit</small>
                    @error('time_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="passing_score" class="form-label">Passing Score (%)</label>
                    <input type="number" class="form-control @error('passing_score') is-invalid @enderror" id="passing_score" name="passing_score" value="{{ old('passing_score') }}" min="0" max="100" required>
                    @error('passing_score')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Quiz</button>
                </div>
            </form>
        </div>
    </div>
@endsection 