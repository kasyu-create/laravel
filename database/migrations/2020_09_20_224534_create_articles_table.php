<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('body');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            // foreignは外部キーを使うという意味。元々foreign key = 外部キーという意味である。
            // 上記の意味としては、articlesテーブルのuser_idカラムは、usersテーブルのidカラムを参照することという制約。
            //こうすることで、articlesテーブルのuser_idカラムには、usersテーブルに存在するidと同じ値しか入れられなくなります。
            //つまり、「記事は存在するけれど、それを投稿したユーザーが存在しない」という状態を作れないようになります。
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
        Schema::dropIfExists('articles');
    }
}
