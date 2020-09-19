<?php

namespace App\Http\Controllers;

use App\Follow;
use App\Post;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
  public function edit(User $user) {
    $myUser = Auth::user();
    $currentUserId = Auth::user()->id;
    $userIdPost = $user->id;
    if ($currentUserId != $userIdPost) {
      toast('Cannot Edit Other User Profile', 'error');
      return redirect()->route('profile', ['user' => $myUser]);
    }
    return view('auth.edit', ['user' => $user]);
  }
  public function update(Request $request, User $user) {
    $request->validate([
      'name' => ['string', 'max:255'],
      'password' => ['nullable', 'string', 'min:8', 'confirmed'],
    ]);
    $userId = Auth::user()->id;
    $userIdPost = $user->id;
    if ($userId != $userIdPost) {
      toast('This is not your Profile', 'error');
      return redirect()->back();
    }
    $datas = $request->all();
    $request->password;
    if ($request->name) {
      $user['name'] = $request->name;
    }
    $oldPassword = $user->password;
    $user['password'] = $oldPassword;
    if ($request->password) {
      $newPassword = Hash::make($request->password);
      $user['password'] = $newPassword;
    }

    $user->save();
    toast('Success Update Profile User', 'success');
    return redirect()->back();
  }
}
