<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model {
  protected $guarded = [
    "id", "created_at", "updated_at",
  ];
  protected $hidden = [
    "created_at", "updated_at",
  ];
  function userFollowing() {
    return $this->belongsTo(User::class, 'user_id');
  }
  function userFollower() {
    return $this->belongsTo(User::class, 'follower_id');
  }
}
