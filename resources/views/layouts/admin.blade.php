<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel') - Quiz App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

<nav class="navbar navbar-dark navbar-expand-lg bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('admin.dashboard') }}">
            Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome') }}">← Wróć do strony</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.quizzes.index') }}">Zarządzaj Quizami</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                     <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Wyloguj
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @yield('content')
</main>

<footer class="text-center text-muted small py-4">
    &copy; {{ date('Y') }} Quiz App - Admin Panel
</footer>

</body>
</html>
