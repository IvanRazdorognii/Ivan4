<!DOCTYPE html>
<html>
<head>
    <title>Список задач</title>
    @vite('resources/css/app.css')
</head>
<body>

<h1>Список задач</h1>

<!-- Кнопка для создания новой задачи -->
<a href="{{ route('tasks.create') }}">
    <button class="btn-create">Создать задачу</button>
</a>

<ul>
    @foreach ($tasks as $task)
        <li>
            <strong>{{ $task->title }}</strong><br>
            <em>Категория: {{ $task->category->name }}</em><br>
            <em>Теги: 
                @foreach ($task->tags as $tag)
                    {{ $tag->name }} 
                @endforeach
            </em><br>
            
            <!-- Кнопка для редактирования задачи -->
            <a href="{{ route('tasks.edit', $task->id) }}">
                <button class="btn-edit">Редактировать</button>
            </a>

            <a href="{{ route('tasks.show', $task->id) }}">Подробнее</a>
        </li>
    @endforeach
</ul>

<button onclick="window.history.back();" class="btn-back">Назад</button>

</body>
</html>
