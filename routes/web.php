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
    Route::get ('/', 'MainController@index')->name ('admin.index');
});










