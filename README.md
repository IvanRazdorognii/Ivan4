# Лабораторная работа №4. Формы и валидация данных
# Цель работы
Познакомиться с основами создания и управления формами в Laravel.Освоить механизмы валидации данных на сервере, использовать предустановленные и кастомные правила валидации, а также научиться обрабатывать ошибки и обеспечивать безопасность данных
## №2. Создание формы
1. Маршруты (web.php)
Добавляем маршрут для формы и сохранения задачи:

php
Копировать
Редактировать
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);
Этот ресурсный маршрут автоматически включает create и store, среди других.

2. Контроллер (TaskController.php)
Добавляем методы create и store:

php
Копировать
Редактировать
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('category')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена!');
    }
}
3. Blade-шаблон для формы (resources/views/tasks/create.blade.php)
