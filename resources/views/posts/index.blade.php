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
            @include('posts.components.postcard',['post' => $post])
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection