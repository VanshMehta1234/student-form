@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $course->title }}</h5>
                        <span class="badge bg-info">{{ ucfirst($course->level) }} Level</span>
                    </div>
                </div>

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
                    
                    @if (session('info'))
                        <div class="alert alert-info" role="alert">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('student.courses.index') }}" class="btn btn-secondary mb-3">
                            <i class="bi bi-arrow-left"></i> Back to Courses
                        </a>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h4>Course Details</h4>
                            <p class="lead">{{ $course->description }}</p>
                            
                            <div class="mt-4">
                                <h5>What You'll Learn</h5>
                                <ul>
                                    <li>Duration: {{ $course->duration }}</li>
                                    <li>Created by: {{ $course->educator->name }} ({{ $course->educator->qualification }})</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Course Progress</h5>
                                    
                                    @if($enrolled)
                                        <div class="progress mb-3">
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ $progress }}%</div>
                                        </div>
                                        
                                        @if($progress == 100)
                                            <div class="alert alert-success">
                                                Congratulations! You've completed this course.
                                            </div>
                                        @endif
                                        
                                        <a href="{{ route('student.courses.my') }}" class="btn btn-primary w-100 mb-2">
                                            Go to My Courses
                                        </a>
                                    @else
                                        <p class="card-text">You are not enrolled in this course yet.</p>
                                        <form action="{{ route('student.courses.enroll', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100">
                                                Enroll Now
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course quizzes section -->
                    <div class="mt-5">
                        <h4>Quizzes</h4>
                        
                        @if($enrolled)
                            @if($course->quizzes->count() > 0)
                                <div class="list-group">
                                    @foreach($course->quizzes as $quiz)
                                        <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $quiz->title }}</h5>
                                                @if($quiz->time_limit)
                                                    <small>Time Limit: {{ $quiz->time_limit }} minutes</small>
                                                @endif
                                            </div>
                                            <p class="mb-1">{{ Str::limit($quiz->description, 100) }}</p>
                                            <small>Passing Score: {{ $quiz->passing_score }}%</small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    No quizzes available for this course yet.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                You need to enroll in this course to access quizzes.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 