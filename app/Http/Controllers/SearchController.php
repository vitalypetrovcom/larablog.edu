<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller { // Контроллер для осуществления поиска статей по названию на сайте

    public function index (Request $request) { // Метод для отображения страницы поиска на сайте

        // Проходим валидацию
        $request->validate ([ // Устанавливаем правила валидации для поля с именем "s" формы поиска. Мы из $request будем брать это имя и проверять его
            's' => 'required',
        ]);
        /*dd ($request->all ()); // Убедимся, что у нас все отрабатывает*/

        $s = $request->s; // Получаем в переменную $s наш поисковый запрос, что запросил пользователь

        // Получаем данные (посты) по данному запросу, в названии которых есть текст поискового запроса. Мы должны получить посты (если таковые будут найдены), если нет - у нас будет пустая коллекция
        /*$posts = Post::where('title', 'LIKE', "%{$s}%")->with('category')->paginate (2);*/ // В условии указываем тип поиска 'LIKE' и указываем шаблон поискового значения "%{$s}%" при использовании оператора 'LIKE'. Дополнительно вытаскиваем связь with('category')
        $posts = Post::like($s)->with('category')->paginate (2);


        return view ('posts.search', compact ('s','posts'));

    }


// ---->> Eloquent: Local Scopes (https://laravel.com/docs/8.x/eloquent#local-scopes).
//  Когда мы делаем какие-либо одинаковые запросы во многих различных методах, чтобы не писать длинные запросы мы можем воспользоваться Scopes, те создавать специальные скоуп-методы в модели и вызывать их оттуда. В этих скоуп-методах будет часть запроса:
    /*// Scope a query to only include popular users.
    public function scopePopular($query)
    {
        return $query->where('votes', '>', 100);
    }
    //Scope a query to only include active users.
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }*/
    // Используются они просто: в том месте, где нам это нужно мы используем эти готовые методы
   /* $users = User::popular()->active()->orderBy('created_at')->get();*/
    // Данные скоуп-методы должны возвращать query-builder, данные которого можно отсортировать ->orderBy('created_at') или что-то еще сделать ... и затем вызвать метод get() чтобы получить коллекцию



}
