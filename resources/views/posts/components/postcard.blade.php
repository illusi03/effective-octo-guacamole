<div class="posts-card">
  <div class="row align-items-center justify-content-between px-3">
    <a href="{{ route('posts.show', ['post' => $post]) }}" class="posts-title">{{ $post->title }}</a>
    <div class="row px-3">
      @if(Auth::user()->id == $post->user_id)
        <a class="btn btn-outline-primary btn-sm mr-2" href="{{ route('posts.edit', ['post' => $post]) }}">Edit</a>
        <form action="{{ route('posts.delete', ['post' => $post]) }}" method="post">
          <input class="btn btn-default btn-sm text-danger delete-confirm" type="submit" value="Delete" />
          @csrf
          @method("DELETE")
        </form>
      @endif
    </div>
  </div>
  @if(!empty($post->url_image))
    <img class="posts-image" src={{ asset("/images/".$post->url_image) }} />
  @endif
  <p class="text-black-50">Description : </p>
  {!! $post->content !!}
  <div class="row px-3 mt-3">
    <span>Posted by : </span>
    <a href={{ route('profile',['user'=>$post->user]) }}>{{ $post->user->name }}</a>
    <span class="px-2" />
    <span>({{ $post->created_at->diffForHumans() }})</span>
  </div>
  <div class="row px-3 mt-0 mb-1">
    <?php $isLiked=false; ?>
    @foreach($post->likes as $like)
      @if(Auth::user()->id == $like->user_id)
        <?php $isLiked=true; ?>
      @endif
    @endforeach
    @if($isLiked)
      <span class="mr-1">
        Already Liked
      </span>
    @else
      <a href="{{ route('posts.like', ['post' => $post]) }}" class="mr-1">
        Like
      </a>
    @endif
    <span class="mr-3">({{ $post->likes_count ?? "0" }} Likes)</span>
    @if(empty($isShow))
      <a href="{{ route('posts.show', ['post' => $post]) }}" class="mr-1">
        Comment
      </a>
    @else
      <p class="mr-1">
        Comment
      </p>
    @endif
    <span class="mr-3">({{ $post->comments_count }} Comments)</span>
  </div>
</div>