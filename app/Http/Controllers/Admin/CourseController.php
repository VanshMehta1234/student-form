<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Educator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('educator')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $educators = Educator::all();
        return view('admin.courses.create', compact('educators'));
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
            'duration' => 'required',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'educator_id' => 'required|exists:educators,id',
        ]);
        
        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $educators = Educator::all();
        return view('admin.courses.edit', compact('course', 'educators'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'duration' => 'required',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'is_active' => 'boolean',
            'educator_id' => 'required|exists:educators,id',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
