<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model { // Модель для работы с тегами постов

    use Sluggable;

    protected $fillable = ['title'];

    // Один тег может принадлежать многим постам и одному посту может принадлежать много тегов. Это связь "многие ко многим". Получив тег мы получаем все посты, которым присвоен данный тег
    public function posts () { // Метод для связи тега и постов

        return $this->belongsToMany (Post::class); // Используем метод belongsToMany для модели Post. Наш тег может иметь много постов

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
