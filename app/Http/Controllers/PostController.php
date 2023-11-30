<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller { // Контроллер для работы с главной страницей

    public function index () { // Метод для отображения главной страницы

        return view ('posts.index');

    }

    public function show () { // Метод для просмотра одной статьи

        return view ('posts.single');

    }

}
