@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Educator Dashboard') }}</div>

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

                    <h4>Welcome, {{ Auth::guard('educator')->user()->name }}!</h4>
                    
                    <div class="mt-4">
                        <h5>Your Profile Information:</h5>
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td>{{ Auth::guard('educator')->user()->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ Auth::guard('educator')->user()->email }}</td>
                            </tr>
                            <tr>
                                <th>Qualification:</th>
                                <td>{{ Auth::guard('educator')->user()->qualification }}</td>
                            </tr>
                            <tr>
                                <th>Bio:</th>
                                <td>{{ Auth::guard('educator')->user()->bio }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-4">
                        <h5>Quick Actions:</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Courses</h5>
                                        <p class="card-text">Manage your courses, create new ones, and track their progress.</p>
                                        <a href="{{ route('educator.courses.index') }}" class="btn btn-primary">Manage Courses</a>
                                        <a href="{{ route('educator.courses.create') }}" class="btn btn-success">Create Course</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Quizzes</h5>
                                        <p class="card-text">Create and manage quizzes for your courses.</p>
                                        <a href="{{ route('educator.quizzes.index') }}" class="btn btn-primary">Manage Quizzes</a>
                                        <a href="{{ route('educator.quizzes.create') }}" class="btn btn-success">Create Quiz</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 