<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('post_id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('post_title', 191);
            $table->text('post_body')->nullable();
            $table->string('post_image', 100)->nullable();
            $table->integer('view_count')->default(0);
            $table->string('post_slug');
            $table->tinyInteger('post_status')->default(0);
            $table->tinyInteger('post_approved')->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
