<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentLike;
use App\Post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
  public function __construct() {
    $this->middleware('auth');
  }
  public function store(Request $request, Post $post) {
    $request->validate([
      'content' => 'required|string',
    ]);
    $userId = Auth::user()->id;
    $datas = $request->all();
    $datas['user_id'] = $userId;
    $datas['post_id'] = $post->id;
    Comment::create($datas);
    toast('Your Comment Has Been Submitted !', 'success');
    return redirect()->route('posts.show', ['post' => $post]);
  }
  public function destroy(Comment $comment) {
    $comment->delete();
    toast('Your Comment Has Been Deleted !', 'success');
    return redirect()->route('posts.show', ['post' => $comment->post_id]);
  }
  public function like(Request $request, Comment $comment) {
    $userId = Auth::user()->id;
    $datas = $request->all();
    $datas['user_id'] = $userId;
    $datas['comment_id'] = $comment->id;
    try {
      CommentLike::create($datas);
    } catch (QueryException $e) {
      $errorCode = $e->errorInfo[1];
      if ($errorCode == 1062) {
        toast('Ups !! Already Liked', 'error');
        return redirect()->route('posts.show', ['post' => $comment->post_id]);
      }
    }
    toast('Comment Has Liked !', 'success');
    return redirect()->route('posts.show', ['post' => $comment->post_id]);
  }
}
