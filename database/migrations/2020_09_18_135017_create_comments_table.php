<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('comments', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable()->unsigned();
      $table->bigInteger('post_id')->nullable()->unsigned();
      $table->text('content');
      $table->timestamps();

      $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
      $table->foreign('post_id')->nullable()->references('id')->on('posts')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('comments');
  }
}
