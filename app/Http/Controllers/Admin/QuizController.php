<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Course;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::with('course')->latest()->paginate(10);
        return view('admin.quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::where('educator_id', auth()->id())->get();
        return view('admin.quizzes.create', compact('courses'));
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

        Quiz::create($validated);

        return redirect()->route('admin.quizzes.index')
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
        return view('admin.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        $courses = Course::where('educator_id', auth()->id())->get();
        return view('admin.quizzes.edit', compact('quiz', 'courses'));
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
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'course_id' => 'required|exists:courses,id',
            'time_limit' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean'
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')
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
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }
}
