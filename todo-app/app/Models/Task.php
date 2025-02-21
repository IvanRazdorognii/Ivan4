<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Указываем массово заполняемые поля
    protected $fillable = [
        'title',
        'description',
        'category_id', // Добавляем category_id
    ];

    public function category()
    {
        return $this->belongsTo(Category::class); // Отношение "Многие к одному"
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tag'); // Отношение "Многие ко многим"
    }
}
