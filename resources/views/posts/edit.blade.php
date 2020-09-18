@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">Update Posts </div>
        <div class="card-body">
          <form method="POST" action="{{ route('posts.update', ['post' => $post]) }}" enctype="multipart/form-data">
            @csrf
            @method("PATCH")
            <div class="form-group row">
              <label for="title" class="col-md-2 col-form-label text-md-right">
                Title Post
              </label>
              <div class="col-md-10">
                <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $post->title ?? "" }}" />
                @error('title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="content" class="col-md-2 col-form-label text-md-right">
                Content Post
              </label>
              <div class="col-md-10">
                <textarea name="content" class="form-control my-editor @error('content') is-invalid @enderror">{!! $post->content ?? "" !!}</textarea>
                @error('content')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="image" class="col-md-2 col-form-label text-md-right">
                Image Post
              </label>
              <div class="col-md-10">
                <div class="custom-file">
                  <input type="file" name="image" id="image" onchange="loadPreview(this);" class="custom-file-input  @error('image') is-invalid @enderror">
                  <label class="custom-file-label" for="inputGroupFile01">Choose File</label>
                  @error('image')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <img class="mt-3" id="preview_img" src="https://www.w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="" width="100" height="100" />
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-10 offset-md-2">
                <button type="submit" class="btn btn-primary">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@include("posts.scripts")