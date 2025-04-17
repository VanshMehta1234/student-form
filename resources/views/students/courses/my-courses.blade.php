@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('My Enrolled Courses') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary mb-3">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                        <a href="{{ route('student.courses.index') }}" class="btn btn-primary mb-3">
                            <i class="bi bi-book"></i> Browse More Courses
                        </a>
                    </div>

                    <div class="row">
                        @if($enrolledCourses->count() > 0)
                            @foreach($enrolledCourses as $course)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $course->title }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                By: {{ $course->educator->name }}
                                            </h6>
                                            
                                            <div class="mt-2 mb-2">
                                                <span class="badge bg-{{ $course->pivot->status == 'completed' ? 'success' : 'primary' }}">
                                                    {{ ucfirst($course->pivot->status) }}
                                                </span>
                                                <span class="badge bg-info">
                                                    {{ ucfirst($course->level) }} Level
                                                </span>
                                            </div>
                                            
                                            <div class="progress mb-3">
                                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" 
                                                     style="width: {{ $course->pivot->progress }}%" 
                                                     aria-valuenow="{{ $course->pivot->progress }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    {{ $course->pivot->progress }}%
                                                </div>
                                            </div>
                                            
                                            <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                                            
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-primary">
                                                    Continue Learning
                                                </a>
                                                
                                                <a href="{{ route('student.quizzes.index', $course->id) }}" class="btn btn-outline-info">
                                                    View Quizzes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="d-flex justify-content-center mt-4">
                                {{ $enrolledCourses->links() }}
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    You haven't enrolled in any courses yet. <a href="{{ route('student.courses.index') }}">Browse available courses</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 