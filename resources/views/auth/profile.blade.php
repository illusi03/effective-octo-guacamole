@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="row justify-content-between align-items-center px-3">
            <span>My Profile</span>
          </div>
        </div>
        <div class="card-body">
          <?php 
          $totalLikePosts = 0; 
          $totalLikeComments = 0;
          ?>
          @foreach($user->posts as $post)
            <?php $totalLikePosts = $totalLikePosts + $post->likes_count ?>
          @endforeach
          @foreach($user->comments as $comment)
            <?php $totalLikeComments = $totalLikeComments + $comment->likes_count ?>
          @endforeach
          <table style="width: 100%">
            <tr>
              <td style="width: 250px">User ID</td>
              <td style="width: 1px">:</td>
              <td>{{ $user->id }}</td>
            </tr>
            <tr>
              <td style="width: 250px">Name</td>
              <td style="width: 1px">:</td>
              <td>{{ $user->name }}</td>
            </tr>
            <tr>
              <td style="width: 250px">Email</td>
              <td style="width: 1px">:</td>
              <td>{{ $user->email }}</td>
            </tr>
            <tr>
              <td style="width: 250px">Posts Count</td>
              <td style="width: 1px">:</td>
              <td>{{ $user->posts_count ?? "0" }} Posts</td>
            </tr>
            <tr>
              <td style="width: 250px">Comments Count</td>
              <td style="width: 1px">:</td>
              <td>{{ $user->comments_count ?? "0" }} Comments</td>
            </tr>
            <tr>
              <td style="width: 250px">Liked Post Count</td>
              <td style="width: 1px">:</td>
              <td>{{ $user->like_posts_count ?? "0" }} Liked</td>
            </tr>
            <tr>
              <td style="width: 250px">Liked Comment Count</td>
              <td style="width: 1px">:</td>
              <td>{{ $user->like_comments_count ?? "0" }} Liked</td>
            </tr>
            <tr>
              <td style="width: 250px">Total Reach Post Likes</td>
              <td style="width: 1px">:</td>
              <td>{{ $totalLikePosts ?? "0" }} Likes</td>
            </tr>
            <tr>
              <td style="width: 250px">Total Reach Comment Likes</td>
              <td style="width: 1px">:</td>
              <td>{{ $totalLikeComments ?? "0" }} Likes</td>
            </tr>
            <tr>
              <td style="width: 250px">Created At</td>
              <td style="width: 1px">:</td>
              <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/M/Y : h:m') }} WIB</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@include("posts.scripts")