@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Admin Dashboard') }}</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Students</h5>
                                </div>
                                <div class="card-body">
                                    <h3 class="text-center">{{ \App\Models\Student::count() }}</h3>
                                    <p class="text-center">Total Students</p>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="btn btn-outline-primary btn-sm w-100">Manage Students</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Educators</h5>
                                </div>
                                <div class="card-body">
                                    <h3 class="text-center">{{ \App\Models\Educator::count() }}</h3>
                                    <p class="text-center">Total Educators</p>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="btn btn-outline-success btn-sm w-100">Manage Educators</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">Courses</h5>
                                </div>
                                <div class="card-body">
                                    <h3 class="text-center">{{ \App\Models\Course::count() }}</h3>
                                    <p class="text-center">Total Courses</p>
                                </div>
                                <div class="card-footer">
                                    <a href="#" class="btn btn-outline-info btn-sm w-100">Manage Courses</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-dark text-white">
                                    <h5 class="mb-0">Recent Activities</h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-center text-muted">Activity log will appear here</p>
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