<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;

class HomeController extends Controller {

  public function __construct() {
    $this->middleware('auth');
  }

  public function index() {
    $posts = Post::with('user', 'likes')
      ->withCount('likes', 'comments')
      ->orderBy('id', 'DESC')
      ->get();
    return view('posts.index', ['posts' => $posts]);
  }
  public function myProfile($userId) {
    $user = User::where('id', '=', $userId)
      ->with(['posts' => function ($query) {
        return $query->withCount('likes');
      }])
      ->with(['comments' => function ($query) {
        return $query->withCount('likes');
      }])
      ->withCount('posts')
      ->withCount('comments')
      ->withCount('likeComments')
      ->withCount('likePosts')
      ->first();
    // dd($user->toArray());
    return view('auth.profile', ['user' => $user]);
  }
}
