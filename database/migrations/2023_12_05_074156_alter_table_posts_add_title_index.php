<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePostsAddTitleIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) { // Метод для добавления индекса к полю title (https://laravel.com/docs/8.x/migrations#creating-indexes) (чтобы записи по названию были проиндексированы и это ускорит их поиск на сайте)

            $table->index('title');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex ('title');
        });
    }
}
