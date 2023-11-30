<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- // Важно иметь в виду, чтобы имена name ('---') админских маршрутов (админ-панель) не были такими же (не было повторов) как имена пользовательских маршрутов (фронтенд - пользовательская часть)

// Маршрут для главной страницы
Route::get('/', 'App\Http\Controllers\PostController@index')->name ('home');

// Маршрут для просмотра отдельной статьи(поста)
Route::get('/article', 'App\Http\Controllers\PostController@show')->name ('posts.single');

// Маршрут для просмотра категорий статей(постов)
Route::get('/category', 'App\Http\Controllers\CategoryController@index')->name ('category.index');



// Маршруты для админ-панели в формате группы и ограничить к ней доступ для пользователей без роли администратора. Указываем префикс url адреса 'prefix' => 'admin' и наймспейс у всех контроллеров будет 'namespace' => 'Admin'. Вторым аргументом мы используем коллбек функцию, в которую будем помещать все админские маршруты
/*Route::get ('/admin', 'Admin\MainController@index');*/ // Запись единичного маршрута
// Запись группы маршрутов
Route::group (['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'admin'], function () { // Добавляем третьим аргументом посредник для контроля доступа к админке
    // Маршрут для главной страницы
    Route::get ('/', 'MainController@index')->name ('admin.index');

    // Маршрут для страницы категорий
    Route::resource ('/categories', 'CategoryController'); // Для каждого метода (action) контроллера 'CategoryController' будет маршрут со своим именем. Чтобы иметь перед глазами эти маршруты, в документации есть таблица для контроллера ресурсов (https://laravel.com/docs/8.x/controllers#actions-handled-by-resource-controller). В Ларавель есть специальная команда чтобы посмотреть все существующие маршруты: php artisan route:list. Для того, чтобы посмотреть только интересующие нас маршруты из полного списка, мы используем предыдущую команду с параметром --path=admin/cat (указываем здесь часть пути admin/cat): php artisan route:list --path=admin/cat

    // Маршрут для страницы тегов
    Route::resource ('/tags', 'TagController');

    // Маршрут для страницы статей
    Route::resource ('/posts', 'PostController');

});

// Заключаем маршруты в группу используя посредник для контроля доступа и отображения нужных нам ссылок ['middleware' => 'guest']
Route::group (['middleware' => 'guest'], function () {
    // Маршрут для показа формы регистрации пользователя
    Route::get('/register', 'App\Http\Controllers\UserController@create')->name ('register.create');

// Маршрут для сохранения данных формы регистрации пользователя
    Route::post('/register', 'App\Http\Controllers\UserController@store')->name ('register.store');

// Маршрут для показа формы авторизации пользователя
    Route::get ('/login', 'App\Http\Controllers\UserController@loginForm')->name ('login.create');

// Маршрут для авторизации пользователя
    Route::post ('/login', 'App\Http\Controllers\UserController@login')->name ('login');
});



// Маршрут для выхода из авторизации пользователя
Route::get ('/logout', 'App\Http\Controllers\UserController@logout')->name ('logout')->middleware ('auth'); // Добавляем к маршруту посредник middleware ('auth'), который отобразит данный маршрут только для авторизованных пользователей 'auth'






