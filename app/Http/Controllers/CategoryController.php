<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller { // Контроллер для работы с категориями



    public function index () { // Метод для отображения страницы категорий

        $posts = Post::orderBy ('id', 'DESC');
        return view ('categories.index');

    }


}
