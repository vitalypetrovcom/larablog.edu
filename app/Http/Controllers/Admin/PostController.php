<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller { // Контроллер для работы со статьями
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function index() { // Метод для отображения списка постов

        $posts = Post::paginate (2); // Объявляем переменную $posts и записываем в нее все наши статьи
        return view ('admin.posts.index', compact ('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() { // Метод для создания статей

        // Получаем категории статей
        $categories = Category::pluck('title', 'id')->all (); // Нам нужно получить не все данные, а только массив данных, в этом массиве должны быть title|id. id нам нужен чтобы у нас был номер категории, именно он попадает в id поста, а title - чтобы пользователь видел название категории и мог ее выбрать. Это можно сделать используя метод pluck, который получит нужные нам данные, при этом - значением будет 1 элемент (у нас это title), а ключом будет 2 элемент (у нас это id)

        // Получаем теги статей
        $tags = Tag::pluck('title', 'id')->all ();

        return view ('admin.posts.create', compact ('categories', 'tags'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) { // Метод для сохранения статьи

        // Указываем правила проводим валидацию
        $request->validate ([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',

        ]);

        dd($request->all ());

        // Сохранение статьи


        // Сообщение, что категория добавлена
        return redirect ()->route ('posts.index')->with ('success', 'Статья добавлена!'); // Делаем редирект на главную страницу наших статей и показываем сообщение с помощью метода with об успешном добавлении статьи

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) { // Метод для изменения существующей статьи

        // Найдем нужную статью по id


        return view ('admin.posts.edit');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) { // Метод для обновления (перезаписи) существующей статьи

        // Указываем правила проводим валидацию
        $request->validate ([
            'title' => 'required',


        ]);
        // Найдем нужную статью по id


        // Сохраняем (перезаписываем) статью


        return redirect ()->route ('posts.index')->with ('success', 'Изменения сохранены!'); // Делаем редирект на главную страницу наших статей и показываем сообщение с помощью метода with об успешном обновлении статьи

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) { // Метод для удаления существующей статьи

//        $post = Post::find($id);
        // Удалим статью
//        $post->delete ();

        return redirect ()->route ('posts.index')->with ('success', 'Статья удалена!'); // Делаем редирект на главную страницу наших статей и показываем сообщение с помощью метода with об успешном удалении статьи

    }
}
