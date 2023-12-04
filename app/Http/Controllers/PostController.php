<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller { // Контроллер для работы с главной страницей

    public function index () { // Метод для отображения главной страницы

        // Полный список статей для главной страницы
        $posts = Post::with('category')->orderBy ('id', 'DESC')->paginate (5); // При получении списка всех статей учитываем связь статей и категорий и получаем категорию статьи (используем метод with('category')). Связь обязательно должна быть использована чтобы у нас не было отправки на сервер лишних SQL запросов чтобы мы "жадно" забрали все данные (мы забираем все статьи, которые предназначены для вывода на данной странице и категории, к которым привязаны эти статьи). Упорядочим вывод статей с помощью order by в порядке убывания 'id'. Используем пагинацию на странице

        return view ('posts.index', compact ('posts'));

    }

    public function show ($slug) { // Метод для просмотра одной статьи. На вход передаем слаг статьи

        // Получаем нужный нам пост
        $post = Post::where('slug', $slug)->firstOrFail (); // Для того, чтобы получить нужный нам пост по 'slug' из БД, мы используем метод where('slug', $slug) и метод firstOrFail (выдает нам первый вариант, соответствующий запросу $slug или возвращает нам ошибку

        // Увеличиваем счетчик просмотров
        $post->views += 1;
        $post->update ();


        /*$posts = Post::with('category')->orderBy ('id', 'DESC')->limit (2);*/

        return view ('posts.show', compact ('post'));

    }

}
