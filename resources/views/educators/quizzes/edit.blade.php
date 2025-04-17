@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Quiz') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('educator.quizzes.update', $quiz) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Quiz Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $quiz->title) }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description', $quiz->description) }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="course_id" class="col-md-4 col-form-label text-md-end">{{ __('Course') }}</label>

                            <div class="col-md-6">
                                <select id="course_id" class="form-control @error('course_id') is-invalid @enderror" name="course_id" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $quiz->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('course_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="time_limit" class="col-md-4 col-form-label text-md-end">{{ __('Time Limit (minutes)') }}</label>

                            <div class="col-md-6">
                                <input id="time_limit" type="number" min="1" class="form-control @error('time_limit') is-invalid @enderror" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}" placeholder="Leave empty for no time limit">

                                @error('time_limit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="passing_score" class="col-md-4 col-form-label text-md-end">{{ __('Passing Score (%)') }}</label>

                            <div class="col-md-6">
                                <input id="passing_score" type="number" min="0" max="100" class="form-control @error('passing_score') is-invalid @enderror" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" required>

                                @error('passing_score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="is_active" class="col-md-4 col-form-label text-md-end">{{ __('Status') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $quiz->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        {{ __('Active') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Quiz') }}
                                </button>
                                <a href="{{ route('educator.quizzes.index') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 