<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller { // Контроллер для работы с категориями

    public function index () { // Метод для отображения страницы категорий

        return view ('categories.index');

    }


}
