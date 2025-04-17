<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8fafc;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }
        .card {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #f0f0f0;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest('student')
                            @guest('educator')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('student.login.form') }}">{{ __('Student Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('student.register.form') }}">{{ __('Student Register') }}</a>
                            </li>
                            @endguest
                        @endguest
                        
                        @guest('educator')
                            @guest('student')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('educator.login.form') }}">{{ __('Educator Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('educator.register.form') }}">{{ __('Educator Register') }}</a>
                            </li>
                            @endguest
                        @endguest
                        
                        @auth('student')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('student')->user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('student.dashboard') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('student.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('student.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                        
                        @auth('educator')
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('educator')->user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('educator.dashboard') }}">
                                        {{ __('Dashboard') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('educator.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('educator.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 