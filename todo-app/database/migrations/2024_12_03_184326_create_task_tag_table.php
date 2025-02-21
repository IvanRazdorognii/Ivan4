<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_tag', function (Blueprint $table) {
            $table->id(); // Первичный ключ
            $table->unsignedBigInteger('task_id'); // Внешний ключ на задачи
            $table->unsignedBigInteger('tag_id'); // Внешний ключ на теги

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // При удалении задачи удаляются записи в этой таблице
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade'); // При удалении тега удаляются записи в этой таблице

            $table->timestamps(); // Для отслеживания времени создания и обновления связей
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_tag');
    }
};
