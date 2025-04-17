@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('My Courses') }}</span>
                    <a href="{{ route('educator.courses.create') }}" class="btn btn-primary btn-sm">Create New Course</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($courses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Duration</th>
                                        <th>Price</th>
                                        <th>Level</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $course->title }}</td>
                                            <td>{{ Str::limit($course->description, 50) }}</td>
                                            <td>{{ $course->duration }}</td>
                                            <td>${{ number_format($course->price, 2) }}</td>
                                            <td>{{ ucfirst($course->level) }}</td>
                                            <td>
                                                @if($course->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('educator.courses.edit', $course) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('educator.courses.destroy', $course) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $courses->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            You haven't created any courses yet. <a href="{{ route('educator.courses.create') }}">Create your first course</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 