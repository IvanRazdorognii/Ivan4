# Лабораторная работа №4. Формы и валидация данных
# Цель работы
Познакомиться с основами создания и управления формами в Laravel.Освоить механизмы валидации данных на сервере, использовать предустановленные и кастомные правила валидации, а также научиться обрабатывать ошибки и обеспечивать безопасность данных
## №2. Создание формы
1. Маршруты (web.php)
Добавляем маршрут для формы и сохранения задачи:
```php
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('tasks', TaskController::class);
```
Этот ресурсный маршрут автоматически включает create и store, среди других.

### 2.Обновите контроллер TaskController
Добавляем методы create и store:
```php
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
```
### 3. Создаем Blade-шаблон для формы (resources/views/tasks/create.blade.php)

### 4. Добавляем due_date в миграцию (create_tasks_table.php)
```php
public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->date('due_date'); // Поле для даты выполнения
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
```
### Запускаем миграции:
```
php artisan migrate
```
### 5. Обновляем Task.php
Добавляем due_date в $fillable:
```
protected $fillable = ['title', 'description', 'due_date', 'category_id'];
```

![image](https://github.com/user-attachments/assets/d997dc98-4a21-4ac8-86f2-7f953c46f32a)

![image](https://github.com/user-attachments/assets/f1903c6e-c0be-4843-bfa6-d9e94a075fdb)

![image](https://github.com/user-attachments/assets/4aa18ee5-425c-4474-8b66-da911be7a599)

## №3. Валидация данных на стороне сервера
### Реализуйте валидацию данных непосредственно в методе store контроллера TaskController.
```php
public function store(Request $request)
{
    // Валидация входных данных
    $validated = $request->validate([
        'title' => 'required|string|min:3',
        'description' => 'nullable|string|max:500',
        'due_date' => 'required|date|after_or_equal:today',
        'category_id' => ['required', 'exists:categories,id'],
    ]);
```
### Обновляем create.blade.php
### В методе create контроллера передаем категории в представление:
```php
public function create()
{
    $categories = Category::all();
    return view('tasks.create', compact('categories'));
}
```
