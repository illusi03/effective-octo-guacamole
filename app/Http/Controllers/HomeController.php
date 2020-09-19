<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Post;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

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
      ->with('followers.userFollower')
      ->with('followings.userFollowing')
      ->withCount('posts')
      ->withCount('comments')
      ->withCount('likeComments')
      ->withCount('likePosts')
      ->withCount('followers')
      ->withCount('followings')
      ->first();
    // dd($user->toArray())
    return view('auth.profile', ['user' => $user]);
  }
  public function follow(Request $request, $userId) {
    $currentId = Auth::user()->id;
    $datas['user_id'] = $userId;
    $datas['follower_id'] = $currentId;
    if ($userId == $currentId) {
      toast('Ups !! Cannot Follow Self User', 'error');
      return redirect()->back();
    }
    try {
      Follow::create($datas);
    } catch (QueryException $e) {
      $errorCode = $e->errorInfo[1];
      if ($errorCode == 1062) {
        toast('Ups !! Already Followed', 'error');
        return redirect()->back();
      }
    }
    toast('Has Followed !', 'success');
    return redirect()->back();
  }
}
