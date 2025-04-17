<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducatorQuizController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:educator');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::whereHas('course', function($query) {
            $query->where('educator_id', Auth::guard('educator')->id());
        })->with('course')->latest()->paginate(10);
        
        return view('educators.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::where('educator_id', Auth::guard('educator')->id())->get();
        return view('educators.quizzes.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'course_id' => 'required|exists:courses,id',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        // Verify that the course belongs to the authenticated educator
        $course = Course::findOrFail($validated['course_id']);
        if ($course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }

        Quiz::create($validated);

        return redirect()->route('educator.quizzes.index')
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        // Check if the quiz belongs to a course owned by the authenticated educator
        if ($quiz->course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('educators.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        // Check if the quiz belongs to a course owned by the authenticated educator
        if ($quiz->course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $courses = Course::where('educator_id', Auth::guard('educator')->id())->get();
        return view('educators.quizzes.edit', compact('quiz', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        // Check if the quiz belongs to a course owned by the authenticated educator
        if ($quiz->course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'course_id' => 'required|exists:courses,id',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        // Verify that the new course belongs to the authenticated educator
        $course = Course::findOrFail($validated['course_id']);
        if ($course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $quiz->update($validated);

        return redirect()->route('educator.quizzes.index')
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        // Check if the quiz belongs to a course owned by the authenticated educator
        if ($quiz->course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $quiz->delete();

        return redirect()->route('educator.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }
} 