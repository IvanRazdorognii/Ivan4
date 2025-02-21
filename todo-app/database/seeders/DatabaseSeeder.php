<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Запуск всех сидеров.
     *
     * @return void
     */
    public function run()
    {
        // Вызов сидеров для заполнения таблиц
        $this->call([
            CategorySeeder::class,
            TaskSeeder::class,
            TagSeeder::class,
        ]);
    }
}

