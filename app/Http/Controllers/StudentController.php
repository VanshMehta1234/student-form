<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Collection;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'min:10'],
            'course' => ['required', 'string', 'max:255']
        ]);

        $student = Student::create($validatedData);
        return response()->json($student, 201);
    }

    public function show(int $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'min:10'],
            'course' => ['required', 'string', 'max:255']
        ]);

        $student->update($validatedData);
        return response()->json($student);
    }

    public function destroy(int $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(null, 204);
    }
} 