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

## №4. Создание собственного класса запроса (Request)
### На втором этапе создайте собственный класс запроса для валидации формы задачи:
```
php artisan make:request CreateTaskRequest
```
### В классе CreateTaskRequest определите правила валидации, аналогичные тем, что были в контроллере.
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Определяем, разрешено ли выполнение запроса.
     */
    public function authorize(): bool
    {
        return true; // Разрешаем выполнение запроса для всех пользователей
    }

    /**
     * Определяем правила валидации.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3',
            'description' => 'nullable|string|max:500',
            'due_date' => 'required|date|after_or_equal:today',
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    /**
     * Сообщения об ошибках (если нужно изменить стандартные).
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название обязательно.',
            'title.min' => 'Название должно содержать минимум 3 символа.',
            'description.max' => 'Описание не может превышать 500 символов.',
            'due_date.required' => 'Дата выполнения обязательна.',
            'due_date.after_or_equal' => 'Дата выполнения должна быть сегодняшней или позднее.',
            'category_id.required' => 'Выберите категорию.',
            'category_id.exists' => 'Выбранная категория не существует.',
        ];
    }
}
```
### Обновите метод store контроллера TaskController для использования CreateTaskRequest вместо стандартного Request.
```php
use App\Http\Requests\CreateTaskRequest;

public function store(CreateTaskRequest $request)
{
    // Данные уже валидированы, можно просто создать задачу
    Task::create($request->validated());

    return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена.');
}
```

![image](https://github.com/user-attachments/assets/47c5e34c-ac52-4dfb-af83-0e8124afaf92)

## №5. Добавление флеш-сообщений
### Обновим store() в TaskController.php
Добавм флеш-сообщение после успешного создания задачи:
```php
public function store(CreateTaskRequest $request)
{
    Task::create($request->validated());

    return redirect()->route('tasks.index')->with('success', 'Задача успешно добавлена.');
}
```
### Выведим флеш-сообщение в Blade-шаблоне
В файле resources/views/layouts/app.blade.php (или в файле, где отображается список задач), добавь код:
```php
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
```

## №6. Защита от CSRF
Добавим @csrf в форму в create.blade.php 
## №7. Обновление задачи
### Создадим представление /edit.blade.php:
2. Создание класса UpdateTaskRequest
Создем новый реквест-компонент:
```
php artisan make:request UpdateTaskRequest
```
### Затем в app/Http/Requests/UpdateTaskRequest.php настроим валидацию:
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|min:3',
            'description' => 'nullable|string|max:500',
            'due_date' => 'required|date|after_or_equal:today',
            'category_id' => ['required', Rule::exists('categories', 'id')],
        ];
    }
}
```
### 3. Добавленим маршрутов в routes/web.php
```php
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
```
4. Обновление TaskController.php
Добавим метод edit(), который передает задачу и список категорий в представление:
```php
public function edit(Task $task)
{
    $categories = Category::all();
    return view('tasks.edit', compact('task', 'categories'));
}
```
Добавим метод update(), который обновляет данные задачи и возвращает пользователя обратно с флеш-сообщением:
```php
public function update(UpdateTaskRequest $request, Task $task)
{
    $task->update($request->validated());

    return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена.');
}
```
# Контрольные вопросы
### Что такое валидация данных и зачем она нужна?
Валидация данных — это процесс проверки данных, полученных от пользователя, на соответствие определённым правилам. Она нужна для обеспечения целостности данных и предотвращения ошибок или атак.

### Как обеспечить защиту формы от CSRF-атак в Laravel?
Защита от CSRF-атак обеспечивается автоматически с помощью токенов, которые вставляются в формы через директиву @csrf в Blade-шаблонах.

### Как создать и использовать собственные классы запросов (Request) в Laravel?
Для создания собственного запроса нужно использовать команду php artisan make:request CustomRequest, затем определить правила валидации в методе rules() и применить его в контроллере.

### Как защитить данные от XSS-атак при выводе в представлении?
Для защиты от XSS-атак следует использовать экранирование данных с помощью функции {{ }} в Blade-шаблонах, которая автоматически преобразует специальные символы в безопасный формат.
