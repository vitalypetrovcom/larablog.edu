<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration { // Миграция для работы с таблицей постов в БД
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments ('id');
            $table->string ('title');
            $table->string ('slug')->unique (); // Для поля 'slug' ставим атрибут unique потому, что у нас в пользовательской части будут выбираться категории, посты, теги именно по полю 'slug', а не по полю 'id'. Если мы сделаем поле 'slug' уникальным (установим индекс уникальный ключ), тогда выборка по данному полю будет гораздо быстрее, чем без такого ключа. На небольших массивах данных это будет незаметно, но если у нас будут тысячи записей, то это будет заметно нагружать систему.
            $table->text ('description');
            $table->text ('content');
            $table->integer ('category_id')->unsigned (); // Связываем пост с категорией колонкой 'category_id' беззнаковый (unsigned)
            /*$table->integer ('category_id', false, true);*/
            $table->integer ('views')->unsigned ()->default (0); // Колонка количества просмотров поста, unsigned, по умолчанию 0.
            $table->string ('thumbnail')->nullable (); // Колонка для хранения картинки поста, картинка не обязательна
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
