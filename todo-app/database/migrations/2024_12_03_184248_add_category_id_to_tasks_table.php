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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(); // Поле для внешнего ключа, допускающее NULL
            $table->foreign('category_id') // Создание внешнего ключа
                  ->references('id')->on('categories')
                  ->onDelete('set null'); // При удалении категории ставим NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // Удаление внешнего ключа
            $table->dropColumn('category_id'); // Удаление поля category_id
        });
    }
};
