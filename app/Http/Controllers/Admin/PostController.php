<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller { // Контроллер для работы со статьями
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function index () { // Метод для отображения списка постов

        $posts = Post::paginate ( 10 ); // Объявляем переменную $posts и записываем в нее все наши статьи
        return view ( 'admin.posts.index', compact ( 'posts' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create () { // Метод для создания статей

        // Получаем категории статей
        $categories = Category::pluck ( 'title', 'id' )->all (); // Нам нужно получить не все данные, а только массив данных, в этом массиве должны быть title|id. id нам нужен чтобы у нас был номер категории, именно он попадает в id поста, а title - чтобы пользователь видел название категории и мог ее выбрать. Это можно сделать используя метод pluck, который получит нужные нам данные, при этом - значением будет 1 элемент (у нас это title), а ключом будет 2 элемент (у нас это id)

        // Получаем теги статей
        $tags = Tag::pluck ( 'title', 'id' )->all ();

        return view ( 'admin.posts.create', compact ( 'categories', 'tags' ) );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store ( Request $request ) { // Метод для сохранения статьи

        // Указываем правила проводим валидацию
        $request->validate ( [
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',

        ] );

        // Принимаем все полученные из формы данные в переменную $data чтобы затем передать их в метод create модели Post
        $data = $request->all ();

        /*// Проверяем, был ли загружен файл 'thumbnail'
        if ($request->hasFile ('thumbnail')) { // Если файл пришел, тогда

            // Формируем путь к файлу. В файле config/filesystems.php указываем Filesystem Disks 'public'. В файле .env прописываем FILESYSTEM_DRIVER=public
            $folder = date('Y-m-d'); // Задаем название папки для картинок

            $data['thumbnail'] = $request->file ('thumbnail')->store ("images/{$folder}"); // Сохраняем файл. Имя файла будет сгенерировано автоматически, чтобы оно было уникальным
        }*/

        $data[ 'thumbnail' ] = Post::uploadImage ( $request ); // Оптимизировали предыдущий код путем создания метода uploadImage в модели Post

        // Сохранение статьи
        $post = Post::create ( $data );


        // Сохранение тегов.
        // Теги мы можем сохранить с помощью связи Many To Many Relationships (https://laravel.com/docs/8.x/eloquent-relationships#updating-many-to-many-relationships). Если нам нужно сохранить какие-либо связанные данные мы можем использовать метод attach. Данный метод прикрепит к id поста id тега. Так же, мы можем открепить данную связь с помощью метода detach. Метод sync - мы передаем ему массив тегов, он проверяет если для указанного поста были уже сохранены каки-то теги (1,2,3) и в новом массиве их нет (4,5) - старые теги удалит, а новые сохранит - те после сохранения теги (4,5) (это самый удобный для нас метод прикрепления тегов)
        $post->tags ()->sync ( $request->tags ); // Используем объект модели $post, мы к нему обращаемся (у нас уже есть id сохраненного поста в этой модели), используем метод tags для связи поста и тегов и затем используем метод sync (в него мы передаем массив тегов - он у нас сохранен в $request->tags - это теги, которые к нам приходят из формы для создания статей)

        // Сообщение, что статья добавлена
        return redirect ()->route ( 'posts.index' )->with ( 'success', 'Статья добавлена!' ); // Делаем редирект на главную страницу наших статей и показываем сообщение с помощью метода with об успешном добавлении статьи

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show ( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit ( $id ) { // Метод для изменения существующей статьи

        // Найдем нужную статью по id
        $post = Post::find ( $id );
        // Получаем категории статей
        $categories = Category::pluck ( 'title', 'id' )->all ();
        // Получаем теги статей
        $tags = Tag::pluck ( 'title', 'id' )->all ();

        return view ( 'admin.posts.edit', compact ( 'post', 'categories', 'tags' ) );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update ( Request $request, $id ) { // Метод для обновления (перезаписи) существующей статьи

        // Указываем правила проводим валидацию
        $request->validate ( [
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image',

        ] );
        // Найдем нужную статью по id
        $post = Post::find ( $id );

        // Принимаем все полученные из формы данные в переменную $data чтобы затем передать их в метод update
        $data = $request->all ();

        /*// Перед тем, как записать новое изображение, нам нужно удалить существующее (если есть) и только потом записать новое изображение в БД
        // Проверяем, передается ли из заполняемой формы файл 'thumbnail'
        if ($request->hasFile ('thumbnail')) { // Если файл пришел, тогда
            // Удаляем существующий файл (если он есть). Для этого используем в классе Facade\Storage метод delete (https://laravel.com/docs/8.x/filesystem#deleting-files)
            Storage::delete ($post->thumbnail);

            $folder = date('Y-m-d'); // Указываем название папки для картинок
            $data['thumbnail'] = $request->file ('thumbnail')->store ("images/{$folder}"); // Сохраняем файл. Имя файла будет сгенерировано автоматически, чтобы оно было уникальным
        }*/

        $data[ 'thumbnail' ] = Post::uploadImage ( $request, $post->thumbnail ); // Оптимизировали предыдущий код путем создания метода uploadImage в модели Post. Дополнительно передаем вторым аргументом картинку, которую мы хотим удалить

        // Обновляем (перезаписываем) статью
        $post->update ( $data );

        // Синхронизируем теги
        $post->tags ()->sync ( $request->tags );

        return redirect ()->route ( 'posts.index' )->with ( 'success', 'Изменения сохранены!' ); // Делаем редирект на главную страницу наших статей и показываем сообщение с помощью метода with об успешном обновлении статьи

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy ( $id ) { // Метод для удаления существующей статьи

        // Получаем пост по id
        $post = Post::find($id);

        // Удаляем связанные данные
        $post->tags()->sync([]); // Все связанные с данным постом теги будут удалены потому как мы передали пустой массив и не одного связанного тега в нем нет
        Storage::delete ($post->thumbnail); // Прикрепленное изображение будет удалено

        // Удалим статью
        $post->delete ();

        return redirect ()->route ( 'posts.index' )->with ( 'success', 'Статья удалена!' ); // Делаем редирект на главную страницу наших статей и показываем сообщение с помощью метода with об успешном удалении статьи

    }
}
