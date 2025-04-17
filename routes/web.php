<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EducatorController;
use App\Http\Controllers\EducatorAuthController;
use App\Http\Controllers\EducatorCourseController;
use App\Http\Controllers\EducatorQuizController;
use App\Http\Controllers\StudentAuthController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Student Routes
Route::get('/student/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login.form');
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.submit');
Route::get('/student/register', [StudentAuthController::class, 'showRegistrationForm'])->name('student.register.form');
Route::post('/student/register', [StudentAuthController::class, 'register'])->name('student.register.submit');
Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
Route::get('/student/dashboard', [StudentAuthController::class, 'dashboard'])->name('student.dashboard')->middleware('auth:student');

// Student Course and Quiz Routes
Route::middleware(['auth:student', 'student.relationships'])->prefix('student')->name('student.')->group(function () {
    // Course routes
    Route::get('/courses', [App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{id}', [App\Http\Controllers\Student\CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{id}/enroll', [App\Http\Controllers\Student\CourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/my-courses', [App\Http\Controllers\Student\CourseController::class, 'myCourses'])->name('courses.my');
    Route::post('/courses/{id}/progress', [App\Http\Controllers\Student\CourseController::class, 'updateProgress'])->name('courses.progress');
    
    // Quiz routes
    Route::get('/courses/{courseId}/quizzes', [App\Http\Controllers\Student\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/{id}', [App\Http\Controllers\Student\QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{id}/start', [App\Http\Controllers\Student\QuizController::class, 'startQuiz'])->name('quizzes.start');
    Route::post('/quizzes/{id}/submit', [App\Http\Controllers\Student\QuizController::class, 'submitQuiz'])->name('quizzes.submit');
    Route::get('/quizzes/{id}/results', [App\Http\Controllers\Student\QuizController::class, 'results'])->name('quizzes.results');
    Route::get('/all-quizzes', [App\Http\Controllers\Student\QuizController::class, 'allQuizzes'])->name('quizzes.all');
});

// Educator Routes (including admin functionality)
Route::get('/educator/login', [EducatorAuthController::class, 'showLoginForm'])->name('educator.login.form');
Route::post('/educator/login', [EducatorAuthController::class, 'login'])->name('educator.login.submit');
Route::get('/educator/register', [EducatorController::class, 'showRegistrationForm'])->name('educator.register.form');
Route::post('/educator/register', [EducatorController::class, 'register'])->name('educator.register.submit');
Route::post('/educator/logout', [EducatorAuthController::class, 'logout'])->name('educator.logout');
Route::get('/educator/dashboard', [EducatorAuthController::class, 'dashboard'])->name('educator.dashboard')->middleware('auth:educator');

// Educator CRUD Routes
Route::middleware(['auth:educator'])->prefix('educator')->name('educator.')->group(function () {
    // Regular educator routes
    Route::resource('courses', EducatorCourseController::class);
    Route::resource('quizzes', EducatorQuizController::class);
    
    // Admin-only routes (for educators with admin role)
    Route::middleware(['admin'])->group(function () {
        // Educator management
        Route::get('/manage-educators', [EducatorController::class, 'index'])->name('manage');
        Route::get('/create-educator', [EducatorController::class, 'create'])->name('create');
        Route::post('/store-educator', [EducatorController::class, 'store'])->name('store');
        Route::get('/edit-educator/{educator}', [EducatorController::class, 'edit'])->name('edit');
        Route::put('/update-educator/{educator}', [EducatorController::class, 'update'])->name('update');
        Route::delete('/delete-educator/{educator}', [EducatorController::class, 'destroy'])->name('destroy');
        
        // All courses (across all educators)
        Route::get('/all-courses', [EducatorCourseController::class, 'allCourses'])->name('all.courses');
        
        // All quizzes (across all educators)
        Route::get('/all-quizzes', [EducatorQuizController::class, 'allQuizzes'])->name('all.quizzes');
    });
});

// Catch any admin/* routes and redirect to educator routes
Route::any('/admin/{any}', function() {
    return redirect('/educator/login')->with('message', 'Please use the educator login. Educators have full access to manage courses and quizzes.');
})->where('any', '.*');
