@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="row justify-content-between align-items-center px-3">
            <span>My List Posts</span>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Posts</a>
          </div>
        </div>
        <div class="card-body">
          @foreach($posts as $post)
            <div class="posts-card">
              <div class="row align-items-center justify-content-between px-3">
                <p class="posts-title">{{ $post->title }}</p>
                <div class="row px-3">
                  <a class="btn btn-outline-primary btn-sm mr-2" href="{{ route('posts.edit', ['post' => $post]) }}">Edit</a>
                  <form action="{{ route('posts.delete', ['post' => $post]) }}" method="post">
                    <input class="btn btn-default btn-sm text-danger delete-confirm" type="submit" value="Delete" />
                    @csrf
                    @method("DELETE")
                  </form>
                </div>
              </div>
              @if(!empty($post->url_image))
                <img class="posts-image" src={{ asset("/images/".$post->url_image) }} />
              @endif
              {!! $post->content !!}
              <div class="row px-3 mt-3">
                <span>Posted On : </span>
                <span>{{ $post->created_at->diffForHumans() }}</span>
              </div>
              <div class="row px-3 mt-0 mb-1">
                <a href="{{ route('posts.like', ['post' => $post]) }}" class="mr-1">
                  Like
                </a>
                <span class="mr-3">(25 Likes)</span>
                <a href="" class="mr-1">
                  Comment
                </a>
                <span class="mr-3">(3 Comments)</span>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection