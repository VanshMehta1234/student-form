<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Educator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EducatorCourseController extends Controller
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
        $courses = Course::where('educator_id', Auth::guard('educator')->id())->latest()->paginate(10);
        return view('educators.courses.index', compact('courses'));
    }
    
    /**
     * Display a listing of all courses (admin only).
     *
     * @return \Illuminate\Http\Response
     */
    public function allCourses()
    {
        $courses = Course::with('educator')->latest()->paginate(10);
        return view('educators.admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('educators.courses.create');
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
        ]);

        $validated['educator_id'] = Auth::guard('educator')->id();
        
        Course::create($validated);

        return redirect()->route('educator.courses.index')
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
        // For admin, allow viewing any course
        if (Auth::guard('educator')->user()->isAdmin()) {
            return view('educators.courses.show', compact('course'));
        }
        
        // For regular educators, check if the course belongs to them
        if ($course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('educators.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        // For admin, allow editing any course
        if (Auth::guard('educator')->user()->isAdmin()) {
            $educators = Educator::all();
            return view('educators.courses.edit', compact('course', 'educators'));
        }
        
        // For regular educators, check if the course belongs to them
        if ($course->educator_id !== Auth::guard('educator')->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('educators.courses.edit', compact('course'));
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
        // For admin, allow updating any course
        if (!Auth::guard('educator')->user()->isAdmin()) {
            // For regular educators, check if the course belongs to them
            if ($course->educator_id !== Auth::guard('educator')->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        $validationRules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'duration' => 'required',
            'price' => 'required|numeric|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'is_active' => 'boolean'
        ];
        
        // Only admins can change the educator
        if (Auth::guard('educator')->user()->isAdmin() && $request->has('educator_id')) {
            $validationRules['educator_id'] = 'required|exists:educators,id';
        }
        
        $validated = $request->validate($validationRules);

        $course->update($validated);

        // Redirect to the appropriate index page
        if (Auth::guard('educator')->user()->isAdmin() && $request->has('admin_view')) {
            return redirect()->route('educator.all.courses')
                ->with('success', 'Course updated successfully.');
        }
        
        return redirect()->route('educator.courses.index')
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
        // For admin, allow deleting any course
        if (!Auth::guard('educator')->user()->isAdmin()) {
            // For regular educators, check if the course belongs to them
            if ($course->educator_id !== Auth::guard('educator')->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        $course->delete();
        
        // Redirect to the appropriate index page
        if (Auth::guard('educator')->user()->isAdmin() && request()->has('admin_view')) {
            return redirect()->route('educator.all.courses')
                ->with('success', 'Course deleted successfully.');
        }

        return redirect()->route('educator.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
} 