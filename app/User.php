<?php

namespace App;

use App\PostLike;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
  use Notifiable;

  protected $guarded = [
    "id", "created_at", "updated_at",
  ];
  protected $hidden = [
    'password', 'remember_token',
  ];
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];
  function posts() {
    return $this->hasMany(Post::class);
  }
  function comments() {
    return $this->hasMany(Comment::class);
  }
  function followers() {
    return $this->hasMany(Follow::class, 'user_id');
  }
  function followings() {
    return $this->hasMany(Follow::class, 'follower_id');
  }
  function likeComments() {
    return $this->hasMany(CommentLike::class);
  }
  function likePosts() {
    return $this->hasMany(PostLike::class);
  }
}
