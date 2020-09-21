@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="row justify-content-between align-items-center px-3">
            <span>Post Detail </span>
          </div>
        </div>
        <div class="card-body">
          @include('posts.components.postcard',['post' => $post,'isShow' => true])
          <p class="text-title-comment">List Comments</p>
          @foreach($post->comments as $comment)
            <div class="posts-comment">
              <p>{{ $comment->user->name }}'s Says : </p>
              {!! $comment->content !!}
              <div class="row px-3 justify-content-between align-items-end">
                <div>
                  <?php 
                  $isAlreadyLike = false;
                  ?>
                  @foreach($comment->likes as $like)
                    @if(Auth::user()->id == $like->user_id)
                      <?php
                      $isAlreadyLike = true;
                      ?>
                    @endif
                  @endforeach

                  @if($isAlreadyLike)
                    <span class="mr-1">
                      Already Liked
                    </span>
                  @else
                    <form method="POST" action="{{ route('comments.like', ['comment' => $comment]) }}" style="display: inline">
                      @csrf
                      <input type="submit" value="Like" class="btn btn-link py-0 px-0 pr-2" />
                    </form>
                  @endif
                  <span>({{ $comment->likes_count ?? "0" }} Likes)</span>
                  <span class="mx-1"> - </span>
                  <span class="text-black-50">Commented on : {{ $comment->created_at->diffForHumans() }}</span>
                </div>
                @if(Auth::user()->id == $comment->user_id)
                  <form action="{{ route('comments.delete', ['comment' => $comment]) }}" method="post">
                    <input class="text-danger p-0 m-0 btn btn-sm btn-link" type="submit" value="Delete" />
                    @csrf
                    @method("DELETE")
                  </form>
                @endif
              </div>
            </div>
          @endforeach
          <div class="mt-4">
            <form method="POST" action="{{ route('comments.store',['post'=>$post]) }}" enctype="multipart/form-data">
              @csrf
              <div class="form-group row">
                <div class="col-md-12">
                  <textarea name="content" class="form-control my-editor @error('content') is-invalid @enderror">{!! old('content', $content ?? "") !!}</textarea>
                  @error('content')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-12 ">
                  <button type="submit" class="btn btn-secondary px-4">
                    Comment
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@include("posts.scripts")