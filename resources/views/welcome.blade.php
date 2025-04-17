<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Learning Management System') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f8fafc;
            }
            .hero-section {
                background-color: #4e73df;
                color: white;
                padding: 80px 0;
            }
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                margin-bottom: 30px;
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
            .card:hover {
                transform: translateY(-10px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
            .card-img-top {
                height: 180px;
                object-fit: cover;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }
            .card-body {
                padding: 25px;
            }
            .card-title {
                font-weight: 700;
                margin-bottom: 15px;
            }
            .btn-portal {
                width: 100%;
                padding: 10px;
                font-weight: 600;
            }
            .footer {
                background-color: #f1f5f9;
                padding: 30px 0;
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
        <header class="bg-white shadow-sm">
            <nav class="navbar navbar-expand-lg navbar-light container">
                <div class="container-fluid">
                    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                        <span class="text-primary">Learning</span> Management System
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#portals">Portals</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#features">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">About</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <section class="hero-section">
            <div class="container text-center">
                <h1 class="display-4 fw-bold mb-4">Welcome to our Learning Management System</h1>
                <p class="lead mb-5">A comprehensive platform for students, educators, and administrators.</p>
                <a href="#portals" class="btn btn-light btn-lg px-5 py-3 fw-bold">Get Started</a>
            </div>
        </section>

        <section id="portals" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold">Access Your Portal</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" class="card-img-top" alt="Student Portal">
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title">Student Portal</h3>
                                <p class="card-text">Access your courses, take quizzes, and track your academic progress.</p>
                                <div class="mt-auto">
                                    @guest('student')
                                        @guest('educator')
                                            <a href="{{ route('student.login.form') }}" class="btn btn-primary btn-portal">Login as Student</a>
                                            <a href="{{ route('student.register.form') }}" class="btn btn-outline-primary btn-portal mt-2">Register as Student</a>
                                        @else
                                            <p class="text-muted">Please log out as educator first.</p>
                                        @endguest
                                    @else
                                        <a href="{{ route('student.dashboard') }}" class="btn btn-primary btn-portal">Go to Dashboard</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" class="card-img-top" alt="Educator Portal">
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title">Educator Portal</h3>
                                <p class="card-text">Create and manage courses, quizzes, and monitor student performance.</p>
                                <div class="mt-auto">
                                    @guest('educator')
                                        @guest('student')
                                            <a href="{{ route('educator.login.form') }}" class="btn btn-success btn-portal">Login as Educator</a>
                                            <a href="{{ route('educator.register.form') }}" class="btn btn-outline-success btn-portal mt-2">Register as Educator</a>
                                        @else
                                            <p class="text-muted">Please log out as student first.</p>
                                        @endguest
                                    @else
                                        <a href="{{ route('educator.dashboard') }}" class="btn btn-success btn-portal">Go to Dashboard</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" class="card-img-top" alt="Management Portal">
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title">Management Portal</h3>
                                <p class="card-text">Manage the entire system, including users, courses, and site settings. Educators can create, update, and delete courses and quizzes.</p>
                                <div class="mt-auto">
                                    @guest('educator')
                                        @guest('student')
                                            <a href="{{ route('educator.login.form') }}" class="btn btn-danger btn-portal">Access Management</a>
                                        @else
                                            <p class="text-muted">Please log out as student first.</p>
                                        @endguest
                                    @else
                                        <a href="{{ route('educator.dashboard') }}" class="btn btn-danger btn-portal">Go to Dashboard</a>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold">Key Features</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <div class="bg-primary text-white d-inline-flex justify-content-center align-items-center rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                </svg>
                            </div>
                            <h4>Course Management</h4>
                            <p>Create, update, and organize courses with ease.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <div class="bg-success text-white d-inline-flex justify-content-center align-items-center rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                </svg>
                            </div>
                            <h4>Quiz Creation</h4>
                            <p>Design and manage assessment quizzes for students.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <div class="bg-danger text-white d-inline-flex justify-content-center align-items-center rounded-circle mb-3" style="width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z"/>
                                </svg>
                            </div>
                            <h4>Performance Tracking</h4>
                            <p>Monitor student progress and academic achievements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 fw-bold">About Our Platform</h2>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3>Modern Learning Environment</h3>
                        <p>Our Learning Management System provides a comprehensive platform for educational institutions, connecting students and educators in a virtual learning environment.</p>
                        <h3 class="mt-4">Who Can Use the Platform?</h3>
                        <ul>
                            <li><strong>Students</strong> - Access course materials, take quizzes, and track progress</li>
                            <li><strong>Educators</strong> - Create and manage courses, generate quizzes, and evaluate student performance</li>
                            <li><strong>Administrators</strong> - Oversee the entire system, manage users, and monitor all activities</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80" class="img-fluid rounded shadow" alt="Learning Platform">
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="container text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Learning Management System. All rights reserved.</p>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
