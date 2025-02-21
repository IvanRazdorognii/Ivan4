<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Определите, авторизован ли пользователь для выполнения этого запроса.
     */
    public function authorize(): bool
    {
        return true; // Разрешить выполнение запроса
    }

    /**
     * Определите правила валидации.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3',
            'description' => 'nullable|string|max:500',
            'due_date' => 'required|date|after_or_equal:today',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    /**
     * Сообщения об ошибках (необязательно).
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Поле "Название" обязательно для заполнения.',
            'title.min' => 'Название должно содержать не менее 3 символов.',
            'description.max' => 'Описание не должно превышать 500 символов.',
            'due_date.after_or_equal' => 'Дата выполнения должна быть сегодняшней или позднее.',
            'category_id.exists' => 'Выбранная категория недействительна.',
        ];
    }
}
