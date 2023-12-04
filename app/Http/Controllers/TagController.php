<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller { // Контроллер для работы с тегами



    public function show ($slug) { // Метод для отображения страницы тегов

        $tag = Tag::where('slug', $slug)->firstOrFail(); // Получаем теги по условию where ('slug', $slug) используя метод firstOrFail получим тег (если он есть) или выдаем ошибку 404
        /*$posts = $tag->posts()->orderBy('id', 'desc')->paginate(1); // Получаем посты используя объект $tag и метод posts(), отсортированные в обратном порядке и пагинация 2 поста на страницу*/
        $posts = $tag->posts()->with ('category')->orderBy('id', 'desc')->paginate(1); // Получаем посты используя объект $tag и метод posts(), отсортированные в обратном порядке и пагинация 2 поста на страницу. Получая посты через связь $tag->posts() мы выбираем еще одну связь with ('category') (вариант жадной загрузки - уменьшаем количество запросов к БД)

        return view('tags.show', compact('tag', 'posts')); // Передаем в представление categories.show переменные 'category', 'posts'

    }


}
