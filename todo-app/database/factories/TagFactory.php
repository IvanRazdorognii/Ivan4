<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * Определите модель, к которой относится фабрика.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Определите состояние модели.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word, // Генерация названия тега
        ];
    }
}
