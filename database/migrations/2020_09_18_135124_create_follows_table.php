<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('follows', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('user_id')->nullable()->unsigned();
      $table->bigInteger('follower_id')->nullable()->unsigned();
      $table->timestamps();

      $table->foreign('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
      $table->foreign('follower_id')->nullable()->references('id')->on('users')->onDelete('cascade');

      $table->unique(['user_id', 'follower_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::dropIfExists('follows');
  }
}
