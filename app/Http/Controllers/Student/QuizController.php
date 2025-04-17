<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:student');
    }
    
    /**
     * Display a listing of quizzes for a specific course.
     *
     * @param  int  $courseId
     * @return \Illuminate\Http\Response
     */
    public function index($courseId)
    {
        $course = Course::with('quizzes')->findOrFail($courseId);
        $student = Auth::guard('student')->user();
        $enrolled = $student->enrolledCourses->contains($courseId);
        
        if (!$enrolled) {
            return redirect()->route('student.courses.show', $courseId)
                ->with('error', 'You must be enrolled in this course to view quizzes.');
        }
        
        $quizzes = $course->quizzes;
        
        return view('students.quizzes.index', compact('course', 'quizzes'));
    }
    
    /**
     * Display the quiz details and questions.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::findOrFail($id);
        $course = $quiz->course;
        $student = Auth::guard('student')->user();
        
        // Check if student is enrolled in the course
        if (!$student->enrolledCourses->contains($course->id)) {
            return redirect()->route('student.courses.index')
                ->with('error', 'You must be enrolled in the course to take this quiz.');
        }
        
        // Check if student has already attempted this quiz
        $attempted = false;
        $attempt = null;
        
        if (method_exists($student, 'quizAttempts')) {
            $attempted = $student->quizAttempts->contains($id);
            $attempt = $attempted ? $student->quizAttempts->find($id)->pivot : null;
        }
        
        return view('students.quizzes.show', compact('quiz', 'course', 'attempted', 'attempt'));
    }
    
    /**
     * Start a quiz attempt.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function startQuiz($id)
    {
        $quiz = Quiz::findOrFail($id);
        $student = Auth::guard('student')->user();
        
        // Check if the quizAttempts relationship exists
        if (!method_exists($student, 'quizAttempts')) {
            return redirect()->route('student.courses.my')
                ->with('error', 'Quiz functionality is not available at the moment.');
        }
        
        // Check if already attempted
        if ($student->quizAttempts->contains($id)) {
            $attempt = $student->quizAttempts->find($id)->pivot;
            
            if ($attempt->status === 'completed') {
                return redirect()->route('student.quizzes.results', $id)
                    ->with('info', 'You have already completed this quiz.');
            }
            
            // Increment attempt count
            $student->quizAttempts()->updateExistingPivot($id, [
                'attempt_count' => $attempt->attempt_count + 1
            ]);
        } else {
            // Create new attempt
            $student->quizAttempts()->attach($id, [
                'status' => 'started',
                'attempt_count' => 1
            ]);
        }
        
        return view('students.quizzes.take', compact('quiz'));
    }
    
    /**
     * Submit a quiz attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submitQuiz(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);
        $student = Auth::guard('student')->user();
        
        // Check if the quizAttempts relationship exists
        if (!method_exists($student, 'quizAttempts')) {
            return redirect()->route('student.courses.my')
                ->with('error', 'Quiz functionality is not available at the moment.');
        }
        
        // Calculate score based on request answers and quiz questions
        // This is a simplified version - in a real app, you would compare answers with correct ones
        $score = $request->score ? $request->score : 0;
        $status = $score >= $quiz->passing_score ? 'completed' : 'failed';
        
        // Update the student's quiz attempt
        $student->quizAttempts()->updateExistingPivot($id, [
            'score' => $score,
            'status' => $status
        ]);
        
        // Update course progress if quiz is passed
        if ($status === 'completed') {
            $course = $quiz->course;
            $totalQuizzes = $course->quizzes->count();
            $completedQuizzes = $student->quizAttempts()
                ->where('status', 'completed')
                ->whereIn('quiz_id', $course->quizzes->pluck('id'))
                ->count();
            
            $progress = ($completedQuizzes / $totalQuizzes) * 100;
            
            // Update course progress
            if (method_exists($student, 'enrolledCourses')) {
                $student->enrolledCourses()->updateExistingPivot($course->id, [
                    'progress' => $progress
                ]);
                
                // If all quizzes completed, mark course as completed
                if ($progress >= 100) {
                    $student->enrolledCourses()->updateExistingPivot($course->id, [
                        'status' => 'completed'
                    ]);
                }
            }
        }
        
        return redirect()->route('student.quizzes.results', $id);
    }
    
    /**
     * Display the quiz results.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function results($id)
    {
        $quiz = Quiz::findOrFail($id);
        $student = Auth::guard('student')->user();
        
        // Check if the quizAttempts relationship exists
        if (!method_exists($student, 'quizAttempts')) {
            return redirect()->route('student.courses.my')
                ->with('error', 'Quiz functionality is not available at the moment.');
        }
        
        if (!$student->quizAttempts->contains($id)) {
            return redirect()->route('student.quizzes.show', $id)
                ->with('error', 'You have not attempted this quiz yet.');
        }
        
        $attempt = $student->quizAttempts->find($id)->pivot;
        
        return view('students.quizzes.results', compact('quiz', 'attempt'));
    }

    /**
     * Display all quizzes from enrolled courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function allQuizzes()
    {
        $student = Auth::guard('student')->user();
        
        // Check if the enrolledCourses relationship exists
        if (!method_exists($student, 'enrolledCourses')) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Course enrollment is not available at the moment.');
        }
        
        $enrolledCourses = $student->enrolledCourses;
        
        if ($enrolledCourses->isEmpty()) {
            return redirect()->route('student.courses.index')
                ->with('info', 'Please enroll in courses to view quizzes.');
        }
        
        $courseIds = $enrolledCourses->pluck('id');
        $allQuizzes = Quiz::whereIn('course_id', $courseIds)->get()->groupBy('course_id');
        
        return view('students.quizzes.all', compact('allQuizzes', 'enrolledCourses'));
    }
}
