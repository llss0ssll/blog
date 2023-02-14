@extends('layouts.app')

@section('title','Edit Post')

@section('content')

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PATCH')

<div class="row mt-2 mb-3">
    <div class="col-4">

        @if ($user->avater)
        <img src="{{ asset('storage/avatar/'.$user->avater) }}" alt="{{ $user->avatar }}" class="img-thmbnail w-100">

        @else
        <i class="fa-solid fa-image fa-10x d-block text-center"></i>
        @endif
    </div>
    <div class="col-8">
        <input type="file" name="avatar" class="form-control mt-1"
        aria-desctibedby="image-info" accept="image/*">
        <div id="image-info" class="form-text">
            Acceptable formats: jpeg, jpg, png, gif only <br>
            Maximum file size: 1048kb
        </div>
        @error('avatar')
            <p class="text-danger">{{ $message }}</p>

        @enderror
    </div>
</div>

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="name" value="{{ old('name',$user->name) }}">
        @error('name')
        <p class="text-danger">{{ $message }}</p>

        @enderror
    </div>
    <div class="mb-3">
        <label for="email" class="farm-label">Email</label>
        <input type="email" name="email" class="form-control"id="email" value="{{ old('email',$user->email) }}">
        @error('email')
        <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
<button type="submit" class="btn btn-warning px-5">Save</button>
</form>

@endsection

