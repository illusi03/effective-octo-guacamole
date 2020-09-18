<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentLikesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('comment_likes', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable()->unsigned();
      $table->bigInteger('comment_id')->nullable()->unsigned();
      $table->string('status')->nullable();
      $table->timestamps();

      $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
      $table->foreign('comment_id')->nullable()->references('id')->on('comments')->onDelete('cascade');

      $table->unique(['user_id', 'comment_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('comment_likes');
  }
}
