<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Post extends Model { // Модель для работы с постами

    use Sluggable;

    protected $fillable = [
        'title',
        'description',
        'content',
        'category_id',
        'thumbnail',
    ];


    // Один пост может иметь много тегов и одному тегу может принадлежать много постов. Это связь "многие ко многим". Получив пост мы получаем все теги, которые есть в данном посте
    public function tags () { // Метод для связи поста и тегов

        return $this->belongsToMany (Tag::class)->withTimestamps (); // Используем метод belongsToMany для модели Tag. Наш пост может иметь много тегов. Для того, чтобы в таблице post_tag автоматически при добавлении записи автоматически заполнялись поля created_at/updated_at, мы используем метод withTimestamps (https://laravel.com/docs/8.x/eloquent-relationships#retrieving-intermediate-table-columns)

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

    public static function uploadImage (Request $request, $image = null) { // Метод для загрузки картинок thumbnails для статей. Данный метод запишет путь к картинке или null (если картинка не передавалась/не загружалась). Вторым аргументом, для метода update в контроллере PostController передаем переменную $image, которая имеет по умолчанию значение null (может отсутствовать)

        // Перед тем, как записать новое изображение, нам нужно удалить существующее (если есть) и только потом записать новое изображение в БД
        // Проверяем, передается ли из заполняемой формы файл 'thumbnail'
        if ($request->hasFile ('thumbnail')) { // Если файл пришел, тогда
            // Удаляем существующий файл (если он есть). Для этого используем в классе Facade\Storage метод delete (https://laravel.com/docs/8.x/filesystem#deleting-files)
            if ( $image ) { // Если у нас есть данные в переменной $image (есть картинка в посте), тогда мы удалим картинку
                Storage::delete ($image);
            }
            $folder = date('Y-m-d'); // Указываем название папки для картинок
            return $request->file ('thumbnail')->store ("images/{$folder}"); // Сохраняем и вернем файл.
        }
        return null;
    }

    public function getImage () { // Метод для получения(отображения) прикрепленной к посту картинке в админке при создании и редактировании статье

        if (!$this->thumbnail) { // Если у модели нет прикрепленного изображения, тогда мы вернем изображение по умолчанию с помощью функции хелпера asset

            return asset("no-image.png"); // asset у нас уже находится в папке public и файл в этой же папке

        }
        return asset("uploads/{$this->thumbnail}"); // Если картинка есть, выводим картинку
    }

    public function getPostDate() { // Метод для вывода даты в читаемом варианте. Используем возможности класса Carbon для работы с датами
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
    }


}
