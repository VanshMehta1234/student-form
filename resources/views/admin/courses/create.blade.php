@extends('admin.layouts.app')

@section('title', 'Create Course')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Create Course</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="educator_id" class="form-label">Educator</label>
                    <select class="form-select @error('educator_id') is-invalid @enderror" id="educator_id" name="educator_id" required>
                        <option value="">Select Educator</option>
                        @foreach($educators as $educator)
                            <option value="{{ $educator->id }}" {{ old('educator_id') == $educator->id ? 'selected' : '' }}>
                                {{ $educator->name }} ({{ $educator->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('educator_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" required>
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                        <option value="">Select Level</option>
                        <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('level')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Course</button>
                </div>
            </form>
        </div>
    </div>
@endsection 