<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // Запись для решения проблемы с ошибкой при выполнении миграции


        view ()->composer ('layouts.sidebar', function ($view) { // Сайдбар, Popular Posts и Categories. Использование метода View Composer для страниц сайта. Аргументом мы указываем для какого вида мы будем передавать эти данные. Аргументом в коллбекфункцию передаем $view (в нее мы будем передавать наши данные)

        // Кеширование сайдбара
        // Запрашиваем из кеша данные
        if (Cache::has('cats')) { // Обращаемся к классу Facade\Cache, проверяем методом has есть ли у нас в кэше данные по ключу 'cats' (для категорий). Если есть, тогда в переменную $cats мы возьмем данные из кэша
            $cats = Cache::get ('cats');
        } else { // Если их там нет, тогда нам нужно их получить
            $cats = Category::withCount('posts')->orderBy ('posts_count', 'desc')->get ();
        // Кладем в кэш по ключу 'cats' данные переменной $cats на время 30сек
        Cache::put ('cats', $cats, 30);
    }

        // Получаем популярные посты Popular Posts
            $view->with('popular_posts', Post::orderBy('views', 'desc')->limit (3)->get()); // Стараемся дать переменной уникальное название, чтобы не было совпадений с другими переменными. Для получения постов нам нужно обратиться к модели Post, нам нужно выбирать посты по признаку views (количество просмотров), отсортируем посты в обратном порядке, получаем записи с помощью метода get()

        // Получаем категории Categories
        /*$view->with('cats', Category::withCount('posts')->orderBy ('posts_count', 'desc')->get ());*/
            $view->with('cats', $cats); // Передаем в представление $cats либо из кэша, либо мы их получим из БД

        // Для получения категорий нам нужно обратиться к модели Category, нам нужно выбирать категории по признаку views (количество постов), отсортируем категории в обратном порядке, получаем записи с помощью метода get().
            // Как нам получить категории и через связи еще получить сколько постов находится в этих категориях? Здесь мы будем использовать метод withCount (https://laravel.com/docs/8.x/eloquent-relationships#counting-related-models) с названием связи, которая нас интересует 'posts' - в этом случае, у нас будет доступно свойство формата {posts}_count. В этом свойстве у нас будет храниться количество постов для конкретной категории.

        } );





    }
}
