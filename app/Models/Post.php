<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model { // Модель для работы с постами

    use Sluggable;

    // Один пост может иметь много тегов и одному тегу может принадлежать много постов. Это связь "многие ко многим". Получив пост мы получаем все теги, которые есть в данном посте
    public function tags () { // Метод для связи поста и тегов

        return $this->belongsToMany (Tag::class); // Используем метод belongsToMany для модели Tag. Наш пост может иметь много тегов

    }

    // Связь поста и категории
    public function category () { // Метод для связи поста и категории

        return $this->belongsTo (Category::class); // Возвращаем связь категории с постом методом belongsTo для модели Category

    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


}
