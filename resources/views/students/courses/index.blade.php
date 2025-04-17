@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Available Courses') }}</div>

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
                        <a href="{{ route('student.courses.my') }}" class="btn btn-success mb-3">
                            <i class="bi bi-book"></i> My Enrolled Courses
                        </a>
                    </div>

                    <div class="row">
                        @if($availableCourses->count() > 0)
                            @foreach($availableCourses as $course)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $course->title }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                By: {{ $course->educator->name }}
                                            </h6>
                                            <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-info">
                                                    {{ ucfirst($course->level) }} Level
                                                </span>
                                                <span>Duration: {{ $course->duration }}</span>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-primary">
                                                    View Details
                                                </a>
                                                @if(isset($enrolledCourses) && $enrolledCourses->contains($course->id))
                                                    <span class="badge bg-success align-self-center p-2">Enrolled</span>
                                                @else
                                                    <form action="{{ route('student.courses.enroll', $course->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success">
                                                            Enroll Now
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="d-flex justify-content-center mt-4">
                                {{ $availableCourses->links() }}
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    No courses available at the moment. Please check back later.
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