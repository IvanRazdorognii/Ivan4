<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Определите модель, к которой относится фабрика.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Определите состояние модели.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence, // Генерация названия задачи
            'description' => $this->faker->paragraph, // Генерация описания задачи
            'category_id' => Category::factory(), // Привязка к категории, используя фабрику Category
        ];
    }
}
