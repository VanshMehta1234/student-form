@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Quizzes for {{ $course->title }}</h5>
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
                        <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-secondary mb-3">
                            <i class="bi bi-arrow-left"></i> Back to Course
                        </a>
                    </div>

                    <div class="row">
                        @if($quizzes->count() > 0)
                            <div class="list-group">
                                @foreach($quizzes as $quiz)
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $quiz->title }}</h5>
                                            
                                            @php
                                                $attempted = $quizAttempts->contains($quiz->id);
                                                $status = $attempted ? $quizAttempts->find($quiz->id)->pivot->status : null;
                                                $score = $attempted ? $quizAttempts->find($quiz->id)->pivot->score : null;
                                            @endphp
                                            
                                            @if($attempted)
                                                <span class="badge bg-{{ $status == 'completed' ? 'success' : ($status == 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($status) }}
                                                    @if($score !== null)
                                                        ({{ $score }}%)
                                                    @endif
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Not Attempted</span>
                                            @endif
                                        </div>
                                        
                                        <p class="mb-1">{{ $quiz->description }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div>
                                                <small class="text-muted me-3">Time Limit: {{ $quiz->time_limit ?? 'No limit' }}</small>
                                                <small class="text-muted">Passing Score: {{ $quiz->passing_score }}%</small>
                                            </div>
                                            
                                            <div class="btn-group">
                                                <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="btn btn-sm btn-outline-primary">
                                                    View Details
                                                </a>
                                                
                                                @if($attempted && $status == 'completed')
                                                    <a href="{{ route('student.quizzes.results', $quiz->id) }}" class="btn btn-sm btn-outline-success">
                                                        View Results
                                                    </a>
                                                @elseif(!$attempted || $status == 'failed')
                                                    <a href="{{ route('student.quizzes.start', $quiz->id) }}" class="btn btn-sm btn-outline-danger">
                                                        {{ $attempted ? 'Retry Quiz' : 'Start Quiz' }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    No quizzes available for this course yet.
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