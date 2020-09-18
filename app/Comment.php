<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
  protected $guarded = [
    "id", "created_at", "updated_at",
  ];
  function user() {
    return $this->belongsTo(User::class);
  }
  function post() {
    return $this->belongsTo(Post::class);
  }
  function likes() {
    return $this->hasMany(CommentLike::class);
  }
}
