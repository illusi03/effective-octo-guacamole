@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Create Posts</div>
        <div class="card-body">
          <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">
              Title
            </label>
            <div class="col-md-6">
              <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title" autocomplete="current-title" />
              @error('title')
                <span class=" invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection