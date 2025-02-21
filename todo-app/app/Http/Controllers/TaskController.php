<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Category;
use App\Models\Tag;

class TaskController extends Controller
{
    public function index()
    {
        // Получаем все задачи с их категорией и тегами (Eager Loading)
        $tasks = Task::with(['category', 'tags'])->get();

        return view('tasks.index', compact('tasks'));
    }

        /**
     * Показать задачу.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Получаем задачу с категорией и тегами по её ID (Eager Loading)
        $task = Task::with(['category', 'tags'])->findOrFail($id);

        return view('tasks.show', compact('task'));
    }


    /**
     * Показать форму для создания новой задачи.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Получаем все категории и теги для выпадающих списков
        $categories = Category::all();
        $tags = Tag::all();

        return view('tasks.create', compact('categories', 'tags'));
    }

        /**
     * Сохранить новую задачу.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTaskRequest  $request)
    {
        // Валидация данных из формы
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);
        
        // Создаем новую задачу
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
        ]);

        // Привязываем теги, если они были выбраны
        if (isset($validated['tags'])) {
            $task->tags()->attach($validated['tags']);
        }

        // Добавление флеш-сообщения
        session()->flash('success', 'Задача успешно создана!');

        return redirect()->route('tasks.index');
    }

        /**
     * Показать форму для редактирования задачи.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $task = Task::with(['category', 'tags'])->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
    
        return view('tasks.edit', compact('task', 'categories', 'tags'));
    }

        /**
     * Обновить задачу.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Валидация данных
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
        ]);

        // Обновляем теги
        $task->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('tasks.show', $task->id);
    }

        /**
     * Удалить задачу.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index');
    }

}

