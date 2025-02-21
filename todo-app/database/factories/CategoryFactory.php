<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Определите модель, к которой относится фабрика.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Определите состояние модели.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word, // Сгенерированное название категории
            'description' => $this->faker->sentence, // Описание категории
        ];
    }
}
