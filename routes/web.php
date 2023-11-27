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

Route::get('/', function () {
    return view('welcome');
});

// Маршруты для админ-панели в формате группы и ограничить к ней доступ для пользователей без роли администратора. Указываем префикс url адреса 'prefix' => 'admin' и наймспейс у всех контроллеров будет 'namespace' => 'Admin'. Вторым аргументом мы используем коллбек функцию, в которую будем помещать все админские маршруты
/*Route::get ('/admin', 'Admin\MainController@index');*/ // Запись единичного маршрута
// Запись группы маршрутов
Route::group (['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin'], function () {
    // Маршрут для главной страницы
    Route::get ('/', 'MainController@index')->name ('admin.index');

    // Маршрут для страницы категорий
    Route::resource ('/categories', 'CategoryController'); // Для каждого метода (action) контроллера 'CategoryController' будет маршрут со своим именем. Чтобы иметь перед глазами эти маршруты, в документации есть таблица для контроллера ресурсов (https://laravel.com/docs/8.x/controllers#actions-handled-by-resource-controller). В Ларавель есть специальная команда чтобы посмотреть все существующие маршруты: php artisan route:list. Для того, чтобы посмотреть только интересующие нас маршруты из полного списка, мы используем предыдущую команду с параметром --path=admin/cat (указываем здесь часть пути admin/cat): php artisan route:list --path=admin/cat

    // Маршрут для страницы тегов
    Route::resource ('/tags', 'TagController');

    // Маршрут для страницы статей
    Route::resource ('/posts', 'PostController');

});










