<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostLikesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('post_likes', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable()->unsigned();
      $table->bigInteger('post_id')->nullable()->unsigned();
      $table->string('status')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
      $table->foreign('post_id')->nullable()->references('id')->on('posts')->onDelete('cascade');

      $table->unique(['user_id', 'post_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('post_likes');
  }
}
