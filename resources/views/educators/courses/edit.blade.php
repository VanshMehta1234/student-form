@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Course') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('educator.courses.update', $course) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Course Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $course->title) }}" required autocomplete="title" autofocus>

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
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description', $course->description) }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="duration" class="col-md-4 col-form-label text-md-end">{{ __('Duration') }}</label>

                            <div class="col-md-6">
                                <input id="duration" type="text" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration', $course->duration) }}" required placeholder="e.g., 8 weeks, 3 months">

                                @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Price ($)') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $course->price) }}" required>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="level" class="col-md-4 col-form-label text-md-end">{{ __('Level') }}</label>

                            <div class="col-md-6">
                                <select id="level" class="form-control @error('level') is-invalid @enderror" name="level" required>
                                    <option value="">Select Level</option>
                                    <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>

                                @error('level')
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
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        {{ __('Active') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Course') }}
                                </button>
                                <a href="{{ route('educator.courses.index') }}" class="btn btn-secondary">
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