<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() { // Метод для отображения категорий


       $categories = Category::paginate (10); // Объявляем переменную $categories и записываем в нее все наши категории с помощью класса Category и метода paginate
       /* dd ($categories);*/

        return view ('admin.categories.index', compact ('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() { // Метод для создания категории

        return view ('admin.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request/*StoreCategory*/ $request) { // Метод для сохранения категории

        // Указываем правила проводим валидацию
        $request->validate ([
            'title' => 'required',
        ]);
        // Сохранение категории
        Category::create($request->all());

        // Сообщение, что категория добавлена
        /*$request->session ()->flash ('success', 'Категория добавлена!');*/

        return redirect ()->route ('categories.index')->with ('success', 'Категория добавлена!'); // Делаем редирект на главную страницу наших категорий и показываем сообщение с помощью метода with об успешном добавлении категории

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) { // Метод для изменения существующей категории

       // Найдем нужную категорию по id
        $category = Category::find($id);
        return view ('admin.categories.edit', compact ('category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) { // Метод для обновления (перезаписи) существующей категории
        // Указываем правила проводим валидацию
        $request->validate ([
            'title' => 'required',
        ]);
        // Найдем нужную категорию по id
        $category = Category::find($id);

        // Если мы хотим поменять slug категории (Это нежелательное действие с точки зрения SEO сайта (появятся битые ссылки))
        /*$category->slug = null;*/ // Это заставит slugable сгенерировать новый slug на основе нового title

        // Сохраняем (перезаписываем) категорию
        $category->update ($request->all ());
        return redirect ()->route ('categories.index')->with ('success', 'Изменения сохранены!'); // Делаем редирект на главную страницу наших категорий и показываем сообщение с помощью метода with об успешном обновлении категории

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) { // Метод для удаления существующей категории

        /*// Найдем нужную категорию по id
        $category = Category::find($id);
        // Удалим категорию
        $category->delete ();*/

        // Альтернативный вариант удаления категории
        Category::destroy ($id);

        return redirect ()->route ('categories.index')->with ('success', 'Категория удалена!'); // Делаем редирект на главную страницу наших категорий и показываем сообщение с помощью метода with об успешном удалении категории

// --->> В Ларавель существует возможность Soft Deleting (фейковое удаление модели) (https://laravel.com/docs/8.x/eloquent#soft-deleting). На самом деле, удаленная таким методом модель не удаляется из БД, она только не показывается в списке моделей. При удалении, по аналогии с вордпресс, происходит перемещение записи в корзину - все наши выборки дальнейшие для показа в пользовательской части будут игнорировать удаленные таким способом модели. Для этого Ларавель добавляет специальное поле deleted_at путем создания и выполнения миграции
    }
}
