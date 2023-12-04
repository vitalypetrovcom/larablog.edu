<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller { // Контроллер для работы с категориями



    public function show ($slug) { // Метод для отображения страницы категорий

        $category = Category::where('slug', $slug)->firstOrFail(); // Получаем категории по условию where ('slug', $slug) используя метод firstOrFail получим категорию (если она есть) или выдаем ошибку 404
        $posts = $category->posts()->orderBy('id', 'desc')->paginate(1); // Получаем посты используя объект $category и метод posts(), отсортированные в обратном порядке и пагинация 2 поста на страницу
        return view('categories.show', compact('category', 'posts')); // Передаем в представление categories.show переменные 'category', 'posts'

    }


}
