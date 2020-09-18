<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostLike;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
  public function __construct() {
    $this->middleware('auth');
  }
  public function index() {
    $userId = Auth::user()->id;
    $posts = Post::with('user', 'likes')
      ->withCount('likes', 'comments')
      ->where('user_id', '=', $userId)
      ->orderBy('id', 'DESC')
      ->get();
    return view('posts.index', ['posts' => $posts]);
  }
  public function create() {
    return view('posts.create');
  }

  public function store(Request $request) {
    $request->validate([
      'title' => 'required|string',
      'content' => 'required|string',
      'image' => 'mimes:jpeg,png,jpg,gif,svg',
      'image.*' => 'mimes:jpeg,png,jpg,gif,svg',
    ]);
    $userId = Auth::user()->id;
    $datas = $request->all();
    $datas['user_id'] = $userId;
    if ($files = $request->file('image')) {
      // Define upload path
      $destinationPath = public_path('/images/'); // upload path
      // Upload Orginal Image
      $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
      $files->move($destinationPath, $profileImage);
      $datas['url_image'] = "$profileImage";
    }
    Post::create($datas);
    toast('Post Has Been Submitted !', 'success');
    return redirect('/');
  }

  public function show(Post $post) {
    $myPost = $post
      ->with(['comments' => function ($query) {
        $query->with('likes')->withCount('likes');
      }])
      ->with('user', 'likes')
      ->withCount('likes', 'comments')
      ->where('id', '=', $post->id)->first();
    // dd($myPost->toArray());
    return view('posts.show', ['post' => $myPost]);
  }

  public function edit(Post $post) {
    return view('posts.edit', ['post' => $post]);
  }

  public function update(Request $request, Post $post) {
    $request->validate([
      'title' => 'required|string',
      'content' => 'required|string',
      'image' => 'mimes:jpeg,png,jpg,gif,svg',
      'image.*' => 'mimes:jpeg,png,jpg,gif,svg',
    ]);
    $userId = Auth::user()->id;
    $userIdPost = $post->user_id;
    if ($userId != $userIdPost) {
      toast('This is not your Post', 'error');
      return redirect('/');
    }
    $datas = $request->all();
    if ($files = $request->file('image')) {
      // Define upload path
      $destinationPath = public_path('/images/'); // upload path
      // Upload Orginal Image
      $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
      $files->move($destinationPath, $profileImage);
      $datas['url_image'] = "$profileImage";
    }
    $post->fill($datas);
    $post->save();
    toast('Post Has Been Updated !', 'success');
    return redirect('/');
  }

  public function destroy(Post $post) {
    $userId = Auth::user()->id;
    $userIdPost = $post->user_id;
    if ($userId != $userIdPost) {
      toast('This is not your Post', 'error');
      return redirect('/');
    }
    toast('Post Has Been Deleted !', 'success');
    $post->delete();
    return redirect('/');
  }

  public function like(Request $request, Post $post) {
    toast('Post Has Been Liked !', 'success');
    $userId = Auth::user()->id;
    $datas = $request->all();
    $datas['user_id'] = $userId;
    $datas['post_id'] = $post->id;
    try {
      PostLike::create($datas);
    } catch (QueryException $e) {
      $errorCode = $e->errorInfo[1];
      if ($errorCode == 1062) {
        toast('Ups !! Already Liked', 'error');
        return redirect()->back();
      }
    }
    toast('Comment Has Liked !', 'success');
    return redirect()->back();
  }
}
