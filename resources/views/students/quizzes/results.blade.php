@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quiz Results: {{ $quiz->title }}</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <h4>Your Score</h4>
                        <div class="display-4 mb-3">{{ $attempt->score }}%</div>
                        
                        @if($attempt->passed)
                            <div class="alert alert-success">
                                <h5 class="alert-heading">Congratulations!</h5>
                                <p>You have passed this quiz with a score of {{ $attempt->score }}%. The passing score was {{ $quiz->passing_score }}%.</p>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <h5 class="alert-heading">Not Passed</h5>
                                <p>You scored {{ $attempt->score }}%, but the passing score is {{ $quiz->passing_score }}%. Please review the material and try again.</p>
                            </div>
                        @endif
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Summary</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Attempt
                                    <span class="badge bg-primary">{{ $attempt->attempt_number }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Date Completed
                                    <span>{{ $attempt->updated_at->format('M d, Y g:i A') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Time Taken
                                    <span>{{ $attempt->time_taken ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Status
                                    @if($attempt->passed)
                                        <span class="badge bg-success">Passed</span>
                                    @else
                                        <span class="badge bg-danger">Failed</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Sample Performance Feedback -->
                    <div class="card mb-4">
                        <div class="card-header">Performance Feedback</div>
                        <div class="card-body">
                            <h6>Question 1: What is the main purpose of Laravel Eloquent?</h6>
                            <p>Your answer: <strong>{{ $attempt->q1_answer == 'b' ? 'Database ORM' : ($attempt->q1_answer == 'a' ? 'Frontend design' : 'Server configuration') }}</strong></p>
                            <p>Correct answer: <strong>Database ORM</strong></p>
                            <div class="mb-3 {{ $attempt->q1_answer == 'b' ? 'text-success' : 'text-danger' }}">
                                {{ $attempt->q1_answer == 'b' ? '✓ Correct' : '✗ Incorrect' }}
                            </div>
                            
                            <h6>Question 2: Which of the following is a Laravel blade directive?</h6>
                            <p>Your answer: <strong>{{ $attempt->q2_answer == 'b' ? '@foreach' : ($attempt->q2_answer == 'a' ? '{# comment #}' : '{{ echo }}') }}</strong></p>
                            <p>Correct answer: <strong>@foreach</strong></p>
                            <div class="{{ $attempt->q2_answer == 'b' ? 'text-success' : 'text-danger' }}">
                                {{ $attempt->q2_answer == 'b' ? '✓ Correct' : '✗ Incorrect' }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('student.quizzes.index', $quiz->course_id) }}" class="btn btn-secondary">
                            Back to Quizzes
                        </a>
                        
                        @if(!$attempt->passed)
                            <a href="{{ route('student.quizzes.take', $quiz->id) }}" class="btn btn-primary">
                                Retry Quiz
                            </a>
                        @else
                            <a href="{{ route('student.courses.show', $quiz->course_id) }}" class="btn btn-success">
                                Continue Learning
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 