@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Taking Quiz: {{ $quiz->title }}</h5>
                        
                        @if($quiz->time_limit)
                            <div id="timer" class="badge bg-danger p-2">
                                Time remaining: <span id="time-left">{{ $quiz->time_limit }}:00</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST" id="quiz-form">
                        @csrf
                        
                        <!-- For demonstration, we'll use a simple mock quiz -->
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">Demo Quiz</h5>
                            <p>This is a demo quiz interface. In a real application, you would fetch questions from the database.</p>
                        </div>
                        
                        <!-- Sample Question 1 -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Question 1</h5>
                                <p class="card-text">What is the main purpose of Laravel Eloquent?</p>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="q1" id="q1_a" value="a">
                                    <label class="form-check-label" for="q1_a">
                                        Frontend design
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="q1" id="q1_b" value="b">
                                    <label class="form-check-label" for="q1_b">
                                        Database ORM
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="q1" id="q1_c" value="c">
                                    <label class="form-check-label" for="q1_c">
                                        Server configuration
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sample Question 2 -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Question 2</h5>
                                <p class="card-text">Which of the following is a Laravel blade directive?</p>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="q2" id="q2_a" value="a">
                                    <label class="form-check-label" for="q2_a">
                                        {# comment #}
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="q2" id="q2_b" value="b">
                                    <label class="form-check-label" for="q2_b">
                                        @foreach
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="q2" id="q2_c" value="c">
                                    <label class="form-check-label" for="q2_c">
                                        {{ echo }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hidden field for score calculation -->
                        <input type="hidden" name="score" id="score" value="0">
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submit-quiz">
                                Submit Quiz
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Calculate score on submit
        document.getElementById('quiz-form').addEventListener('submit', function(e) {
            // Simple score calculation (in real app, you'd compare with correct answers)
            let score = 0;
            const q1Answer = document.querySelector('input[name="q1"]:checked');
            const q2Answer = document.querySelector('input[name="q2"]:checked');
            
            // Check answers (correct answers are b for both questions in this demo)
            if (q1Answer && q1Answer.value === 'b') score += 50;
            if (q2Answer && q2Answer.value === 'b') score += 50;
            
            document.getElementById('score').value = score;
        });
        
        // Timer functionality if there's a time limit
        const timerElement = document.getElementById('timer');
        if (timerElement) {
            const timeDisplay = document.getElementById('time-left');
            const timeParts = timeDisplay.textContent.split(':');
            let totalSeconds = parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
            
            const timer = setInterval(function() {
                totalSeconds--;
                
                if (totalSeconds <= 0) {
                    clearInterval(timer);
                    alert('Time is up! The quiz will be submitted automatically.');
                    document.getElementById('quiz-form').submit();
                    return;
                }
                
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                timeDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            }, 1000);
        }
    });
</script>
@endpush
@endsection 