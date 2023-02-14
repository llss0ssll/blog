@extends('layouts.app')
@section('title','Show Post')

@section('content')

<div class="mt-2 border border-2 rounded py-3 px-4 shadouw-sm">

    <h2 class="h4">{{ $post->title }}</h2>

    <h3 class="h6 text-muted">{{ $post->user->name }}</h3>
    <p>{{ $post->body }}</p>

    <img src="{{ asset('/storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="w-100 shadow">
</div>

<form action="{{ route('comment.store',$post->id) }}" method="POST">
    @csrf

    <div class="input-group my-5">
        <input type="text" class="form-control" value="{{ old('comment') }}"
        placeholder="Add a comment..." name="comment">

        <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
    </div>
    @error('comment')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</form>

<div class="mt-2 mb-5">

    @forelse ($post->comments->sortByDesc('created_at') as $comment)
    <div class="row p-2">
        <div class="col-8">
            <span class="fw-bold">{{ $comment->user->name }}</span>
            &nbsp;
            <span class="small text-muted">{{ $comment->created_at->diffForHumans() }}</span>
            <p class="mb-0">{{ $comment->body }}</p>

        </div>
        <div class="col-4 text-end">
            {{-- check if the comment is from the currently logged in use --}}
            @if ($comment->user->id === Auth::user()->id)

            @include('posts.components.modal')


            <form action="{{ route('comment.destroy',$comment->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" title="Dalete Comment">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>

            @endif
        </div>
    </div>

    @empty

    @endforelse
</div>

@endsection
