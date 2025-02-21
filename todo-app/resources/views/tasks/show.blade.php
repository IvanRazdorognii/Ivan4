<!DOCTYPE html>
<html>
<head>
    <title>Задача</title>
    @vite('resources/css/app.css')
</head>
<body>

<h1>{{ $task->title }}</h1>

<p>{{ $task->description }}</p>

<p><strong>Категория:</strong> {{ $task->category->name }}</p>

<p><strong>Теги:</strong>
    @foreach ($task->tags as $tag)
        {{ $tag->name }} 
    @endforeach
</p>

<a href="{{ route('tasks.index') }}">Назад</a>

</body>
</html>
