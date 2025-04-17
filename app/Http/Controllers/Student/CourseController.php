<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
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
     * Display a listing of all available courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $availableCourses = Course::where('is_active', true)->latest()->paginate(10);
        $student = Auth::guard('student')->user();
        
        // Check if enrolledCourses relationship exists and initialize if not
        $enrolledCourses = collect([]);
        if (method_exists($student, 'enrolledCourses')) {
            $enrolledCourses = $student->enrolledCourses;
        }
        
        return view('students.courses.index', compact('availableCourses', 'enrolledCourses'));
    }
    
    /**
     * Display the specified course details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::with('quizzes')->findOrFail($id);
        $student = Auth::guard('student')->user();
        
        // Check if enrolledCourses relationship exists
        $enrolled = false;
        $progress = 0;
        
        if (method_exists($student, 'enrolledCourses')) {
            $enrolled = $student->enrolledCourses->contains($id);
            if ($enrolled) {
                $progress = $student->enrolledCourses->find($id)->pivot->progress;
            }
        }
        
        return view('students.courses.show', compact('course', 'enrolled', 'progress'));
    }
    
    /**
     * Enroll the student in a course.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function enroll($id)
    {
        $course = Course::findOrFail($id);
        $student = Auth::guard('student')->user();
        
        // Check if enrolledCourses relationship exists
        if (!method_exists($student, 'enrolledCourses')) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Course enrollment is not available at the moment.');
        }
        
        // Check if already enrolled
        if ($student->enrolledCourses->contains($id)) {
            return redirect()->route('student.courses.show', $id)
                ->with('info', 'You are already enrolled in this course.');
        }
        
        // Enroll the student
        $student->enrolledCourses()->attach($id, [
            'status' => 'enrolled',
            'progress' => 0
        ]);
        
        return redirect()->route('student.courses.show', $id)
            ->with('success', 'You have successfully enrolled in this course.');
    }
    
    /**
     * Show the dashboard with student's enrolled courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function myCourses()
    {
        $student = Auth::guard('student')->user();
        
        // Check if enrolledCourses relationship exists
        if (!method_exists($student, 'enrolledCourses')) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Course enrollment is not available at the moment.');
        }
        
        $enrolledCourses = $student->enrolledCourses()->paginate(10);
        
        return view('students.courses.my-courses', compact('enrolledCourses'));
    }
    
    /**
     * Update student's progress in a course.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProgress(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $student = Auth::guard('student')->user();
        
        // Check if enrolledCourses relationship exists
        if (!method_exists($student, 'enrolledCourses')) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Course enrollment is not available at the moment.');
        }
        
        // Check if enrolled
        if (!$student->enrolledCourses->contains($id)) {
            return redirect()->route('student.courses.index')
                ->with('error', 'You are not enrolled in this course.');
        }
        
        // Update progress
        $student->enrolledCourses()->updateExistingPivot($id, [
            'progress' => $request->progress
        ]);
        
        // If progress is 100%, mark as completed
        if ($request->progress >= 100) {
            $student->enrolledCourses()->updateExistingPivot($id, [
                'status' => 'completed'
            ]);
        }
        
        return redirect()->route('student.courses.show', $id)
            ->with('success', 'Your progress has been updated.');
    }
}
