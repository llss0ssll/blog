@extends('layouts.app')

@section('title','Create Post')
@section('content')


<form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="mb-3">
        <label for="title" class="form-label text-muted">Title</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Enter title here" autofocus value="{{ old('title') }}">
        @error('title')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="body" class="form-label text-muted">Body</label>
        <textarea type="text" name="body" id="body" class="form-control" placeholder="Enter body here">{{ old('body') }}</textarea>
        @error('body')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image" class="form-label text-muted">Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*" aria-describedby="image-info">
        <div class="form-text" id="image-info">
            Acceptable formats: jpeg, jpg, png, gif only <br>
            Maximum file size: 1048kb
        </div>
        @error('image')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary px-5">Post</button>
</form>
@endsection
