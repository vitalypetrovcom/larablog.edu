<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller { // Контроллер для работы с админ-панелью

    public function index () { // Метод для отображения админ-панели

        return view ('admin.index');

    }

}
