<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ToDo App')</title>
    @vite('resources/css/app.css')

</head>
<body>
    <header>
        <nav>
            <a href="{{ route('home') }}">Главная</a>
            <a href="{{ route('tasks.index') }}">Задачи</a>
            <a href="{{ route('about') }}">О нас</a>
        </nav>
    </header>
    <main>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>
    <footer>
        <p>&copy; 2024 ToDoApp</p>
    </footer>
</body>
</html>
