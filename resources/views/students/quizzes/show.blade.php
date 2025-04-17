@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $quiz->title }}</h5>
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
                        <a href="{{ route('student.quizzes.index', $course->id) }}" class="btn btn-secondary mb-3">
                            <i class="bi bi-arrow-left"></i> Back to Quizzes
                        </a>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Quiz Information</h5>
                            <p class="card-text">{{ $quiz->description }}</p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Course:</strong> {{ $course->title }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Time Limit:</strong> {{ $quiz->time_limit ? $quiz->time_limit . ' minutes' : 'No limit' }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Passing Score:</strong> {{ $quiz->passing_score }}%
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Your Status</h6>
                                            
                                            @if($attempted)
                                                <p class="card-text">
                                                    <strong>Status:</strong> 
                                                    <span class="badge bg-{{ $attempt->status == 'completed' ? 'success' : ($attempt->status == 'failed' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($attempt->status) }}
                                                    </span>
                                                </p>
                                                
                                                @if($attempt->score !== null)
                                                    <p class="card-text">
                                                        <strong>Score:</strong> {{ $attempt->score }}%
                                                    </p>
                                                @endif
                                                
                                                <p class="card-text">
                                                    <strong>Attempts:</strong> {{ $attempt->attempt_count }}
                                                </p>
                                                
                                                <div class="d-grid gap-2">
                                                    @if($attempt->status == 'completed')
                                                        <a href="{{ route('student.quizzes.results', $quiz->id) }}" class="btn btn-success">
                                                            View Results
                                                        </a>
                                                    @else
                                                        <a href="{{ route('student.quizzes.start', $quiz->id) }}" class="btn btn-primary">
                                                            Retry Quiz
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <p class="card-text">You haven't attempted this quiz yet.</p>
                                                
                                                <a href="{{ route('student.quizzes.start', $quiz->id) }}" class="btn btn-primary">
                                                    Start Quiz
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <h5 class="alert-heading">Quiz Rules</h5>
                        <ul>
                            <li>Answer all questions to the best of your ability.</li>
                            <li>You need to score at least {{ $quiz->passing_score }}% to pass this quiz.</li>
                            @if($quiz->time_limit)
                                <li>You have {{ $quiz->time_limit }} minutes to complete this quiz once started.</li>
                            @endif
                            <li>You can attempt this quiz multiple times if you don't pass.</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection 