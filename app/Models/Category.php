<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model { // Модель для работы с категориями постов

    use Sluggable;

    protected $fillable = ['title']; // Указываем, что мы разрешаем для данной модели массово заполнять title

    // Нам нужно указать связь категорий и поста. Наша категория может иметь много постов (связь "один ко многим" ИЛИ "многие к одному"). Нам нужна связь с помощью метода hasMany
    public function posts () { // Метод для связи категории и постов

        return $this->hasMany (Post::class); // Используем метод hasMany для модели Post. Наша категория имеет много постов

    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array { // Поле 'slug' будет заполняться из источника - поля 'title'
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


}
