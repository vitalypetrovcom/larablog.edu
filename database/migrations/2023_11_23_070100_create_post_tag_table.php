<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration { // Миграция для работы с связующей таблицей постов и тегов в БД. При именовании при создании миграции мы следуем конвенции Ларавель: названия используемых моделей Post/Tag идут в алфавитном порядке в единственном числе post_tag - 2023_11_23_070100_create_post_tag_table.php
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->increments ('id');
            $table->integer ('tag_id')->unsigned (); // Поле в таблице постов tag_id ссылается на таблицу тегов
            $table->integer ('post_id')->unsigned (); // Поле в таблице тегов post_id ссылается на таблицу постов
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
        Schema::dropIfExists('post_tag');
    }
}
