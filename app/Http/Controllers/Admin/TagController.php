<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller { // Контроллер для работы с тегами
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() { // Метод для отображения тегов


       $tags = Tag::paginate (2); // Объявляем переменную $categories и записываем в нее все наши категории с помощью класса Category и метода paginate

        return view ('admin.tags.index', compact ('tags'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() { // Метод для создания тега

        return view ('admin.tags.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request/*StoreCategory*/ $request) { // Метод для сохранения тега

        // Указываем правила проводим валидацию
        $request->validate ([
            'title' => 'required',
        ]);
        // Сохранение тега
        Tag::create($request->all());

        // Сообщение, что категория добавлена
        /*$request->session ()->flash ('success', 'Категория добавлена!');*/

        return redirect ()->route ('tags.index')->with ('success', 'Тег добавлен!'); // Делаем редирект на главную страницу наших категорий и показываем сообщение с помощью метода with об успешном добавлении тега

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) { // Метод для изменения существующего тега

       // Найдем нужный тег по id
        $tag = Tag::find($id);
        return view ('admin.tags.edit', compact ('tag'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) { // Метод для обновления (перезаписи) существующего тега
        // Указываем правила проводим валидацию
        $request->validate ([
            'title' => 'required',
        ]);
        // Найдем нужный тег по id
        $tag = Tag::find($id);

        // Если мы хотим поменять slug тега (Это нежелательное действие с точки зрения SEO сайта (появятся битые ссылки))
        /*$category->slug = null;*/ // Это заставит slugable сгенерировать новый slug на основе нового title

        // Сохраняем (перезаписываем) тег
        $tag->update ($request->all ());
        return redirect ()->route ('tags.index')->with ('success', 'Изменения сохранены!'); // Делаем редирект на главную страницу наших тегов и показываем сообщение с помощью метода with об успешном обновлении тега

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) { // Метод для удаления существующего тега

        /*// Найдем нужную категорию по id
        $category = Category::find($id);
        // Удалим категорию
        $category->delete ();*/

        // Альтернативный вариант удаления тега
        Tag::destroy ($id);

        return redirect ()->route ('tags.index')->with ('success', 'Тег удален!'); // Делаем редирект на главную страницу наших тегов и показываем сообщение с помощью метода with об успешном удалении тега


    }
}
