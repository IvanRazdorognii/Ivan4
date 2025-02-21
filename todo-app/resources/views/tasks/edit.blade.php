<!DOCTYPE html>
<html>
<head>
    <title>Редактировать задачу</title>
    @vite('resources/css/app.css')
</head>
<body>

<h1>Редактировать задачу</h1>

<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="title">Название задачи:</label>
    <input type="text" name="title" id="title" value="{{ $task->title }}" required><br>

    <label for="description">Описание:</label>
    <textarea name="description" id="description">{{ $task->description }}</textarea><br>

    <label for="category_id">Категория:</label>
    <select name="category_id" id="category_id" required>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $category->id == $task->category_id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select><br>

    <label for="tags">Теги:</label>
    <select name="tags[]" id="tags" multiple>
        @foreach ($tags as $tag)
            <option value="{{ $tag->id }}" 
                {{ in_array($tag->id, $task->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                {{ $tag->name }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Сохранить изменения</button>
</form>

</body>
</html>
