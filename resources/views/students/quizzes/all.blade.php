@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('All Quizzes From My Courses') }}</div>

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
                        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary mb-3">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                        <a href="{{ route('student.courses.my') }}" class="btn btn-success mb-3">
                            <i class="bi bi-book"></i> My Enrolled Courses
                        </a>
                    </div>

                    @if($allQuizzes->count() > 0)
                        @foreach($allQuizzes as $courseId => $quizzes)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        {{ $enrolledCourses->find($courseId)->title }} Quizzes
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Time Limit</th>
                                                    <th>Passing Score</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($quizzes as $quiz)
                                                    <tr>
                                                        <td>{{ $quiz->title }}</td>
                                                        <td>{{ $quiz->time_limit }} minutes</td>
                                                        <td>{{ $quiz->passing_score }}%</td>
                                                        <td>
                                                            @php
                                                                $student = Auth::guard('student')->user();
                                                                $attempted = $student->quizAttempts->contains($quiz->id);
                                                                $attempt = $attempted ? $student->quizAttempts->find($quiz->id)->pivot : null;
                                                            @endphp
                                                            
                                                            @if($attempted)
                                                                @if($attempt->status == 'completed')
                                                                    <span class="badge bg-success">Passed ({{ $attempt->score }}%)</span>
                                                                @elseif($attempt->status == 'failed')
                                                                    <span class="badge bg-danger">Failed ({{ $attempt->score }}%)</span>
                                                                @else
                                                                    <span class="badge bg-warning">Started</span>
                                                                @endif
                                                            @else
                                                                <span class="badge bg-secondary">Not Attempted</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('student.quizzes.show', $quiz->id) }}" class="btn btn-sm btn-primary">
                                                                View Quiz
                                                            </a>
                                                            
                                                            @if($attempted && $attempt->status == 'completed')
                                                                <a href="{{ route('student.quizzes.results', $quiz->id) }}" class="btn btn-sm btn-info">
                                                                    View Results
                                                                </a>
                                                            @elseif(!$attempted || $attempt->status != 'completed')
                                                                <a href="{{ route('student.quizzes.start', $quiz->id) }}" class="btn btn-sm btn-success">
                                                                    {{ $attempted ? 'Continue' : 'Start' }} Quiz
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info" role="alert">
                            No quizzes available in your enrolled courses. Please check back later or enroll in more courses.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 