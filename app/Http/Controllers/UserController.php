<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller { // Контроллер для работы с пользователями

    public function create () { // Метод для показа формы для регистрации пользователя

        return view ('user.create');

    }


    public function store (Request $request) { // Метод для сохранения данных из формы для регистрации пользователя

        // Определяем правила валидации
        $request->validate ([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        /*dd ($request->all ()); // Распечатка промежуточного результата после валидации*/

        // Сохраняем пользователя
        $user = User::create([ // Объявляем переменную $user для сохранения полученных данных, используем модель User и метод create (в него мы передаем нужные для регистрации данные)
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt ($request->password), // Для хеширования пароля мы можем использовать функцию хелпер bcrypt (https://laravel.com/docs/8.x/helpers#method-bcrypt) (альтернатива Facade\Hash и методу make)
        ]);

        // Выводим сообщение об успешной регистрации
        session ()->flash ('success', 'Регистрация прошла успешно!');

        // Авторизуем пользователя на сайте
        Auth::login ($user); // Для этого используем класс Facade\Auth и метод login на вход передаем объект $user

        return redirect()->home (); // Делаем редирект пользователя на главную страницу

    }

    public function loginForm () { // Метод для показа формы авторизации пользователя

        return view ('user.login');

    }


    public function login (Request $request) { // Метод для авторизации пользователя

        // Определяем правила валидации
        $request->validate ([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Авторизовываем пользователя. Дополнительно, реализуем редирект 1) если админ - на админку, 2) если обычный пользователь - пользовательская часть сайта главная страница
        if (Auth::attempt ([ // Авторизуем пользователя по следующим полям:
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            session ()->flash ('success', 'Пользователь авторизован на сайте!'); // Запишем в сессию сообщение об успешной авторизации
            if ( Auth::user ()->is_admin ) { // Если пользователь администратор
                return redirect ()->route ('admin.index');
            } else {
                return redirect()->home (); // Делаем редирект пользователя на главную страницу
            }
        }

        // Если пользователь не прошел авторизацию
        return redirect ()->back()->with ('error', 'Неправильный логин/пароль!'); // Делаем редирект на предыдущую страницу и показываем сообщение об ошибке.

    }


    public function logout () { // Метод для выхода из авторизации пользователя

        Auth::logout ();
        return redirect ()->route ('login.create');

    }







}
