@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Student Dashboard') }}</div>

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

                    <h4>Welcome, {{ Auth::guard('student')->user()->name }}!</h4>
                    
                    <div class="mt-4">
                        <h5>Your Profile Information:</h5>
                        <table class="table">
                            <tr>
                                <th>Name:</th>
                                <td>{{ Auth::guard('student')->user()->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ Auth::guard('student')->user()->email }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td>{{ Auth::guard('student')->user()->dob->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ Auth::guard('student')->user()->phone }}</td>
                            </tr>
                            <tr>
                                <th>Course:</th>
                                <td>{{ Auth::guard('student')->user()->course }}</td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Quick Actions:</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Available Courses</h5>
                                        <p class="card-text">Browse and enroll in courses created by educators.</p>
                                        <a href="{{ route('student.courses.index') }}" class="btn btn-primary">Browse Courses</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">My Enrolled Courses</h5>
                                        <p class="card-text">View and continue your enrolled courses.</p>
                                        <a href="{{ route('student.courses.my') }}" class="btn btn-success">My Courses</a>
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