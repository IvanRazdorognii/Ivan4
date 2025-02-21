<!DOCTYPE html>
<html>
<head>
    <title>Создать задачу</title>
    @vite('resources/css/app.css')
</head>
<body>

<h1>Создать новую задачу</h1>

<form action="{{ route('tasks.store') }}" method="POST">
    @csrf

    <label for="title">Название задачи:</label>
    <input type="text" name="title" id="title" required><br>

    <label for="description">Описание:</label>
    <textarea name="description" id="description"></textarea><br>

    <label for="category_id">Категория:</label>
    <select name="category_id" id="category_id" required>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select><br>

    <label for="tags">Теги:</label>
    <select name="tags[]" id="tags" multiple>
        @foreach ($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
        @endforeach
    </select><br>

    <button type="submit">Создать задачу</button>
</form>

</body>
</html>
