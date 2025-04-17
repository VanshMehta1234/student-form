@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('My Quizzes') }}</span>
                    <a href="{{ route('educator.quizzes.create') }}" class="btn btn-primary btn-sm">Create New Quiz</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($quizzes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Time Limit</th>
                                        <th>Passing Score</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quizzes as $quiz)
                                        <tr>
                                            <td>{{ $quiz->title }}</td>
                                            <td>{{ $quiz->course->title }}</td>
                                            <td>{{ $quiz->time_limit ? $quiz->time_limit . ' minutes' : 'No limit' }}</td>
                                            <td>{{ $quiz->passing_score }}%</td>
                                            <td>
                                                @if($quiz->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('educator.quizzes.show', $quiz) }}" class="btn btn-info btn-sm">View</a>
                                                    <a href="{{ route('educator.quizzes.edit', $quiz) }}" class="btn btn-primary btn-sm">Edit</a>
                                                    <form action="{{ route('educator.quizzes.destroy', $quiz) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this quiz?')">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $quizzes->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            You haven't created any quizzes yet. <a href="{{ route('educator.quizzes.create') }}">Create your first quiz</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 