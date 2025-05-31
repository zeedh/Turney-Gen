@extends('dashboard.champs.layouts.main')

@section('container')
<div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h1>Hai</h1>
                <h2>{{ $post->title }} </h2>
                <a href="/dashboard/champs" class="btn btn-success">Back to all My Posts</a>
                <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning">Edit</a>
                <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="btn btn-danger" onclick="return confirm('Yakin?')">Delete</button>
                </form>
                
                @if($post->image)
                <div style="max height: 350px; overflow:hidden">
                    <img src="{{ asset('storage/'.$post->image) }}" class="img-fluid mt-3">
                </div>
                
                @else
                <img src="https://picsum.photos/id/{{$post->category->id}}/1200/400" alt="{{ $post->category->name }}" 
                class="img-fluid mt-3">

                @endif

                <article class="my-3 fs-6">
                    {!! $post->body !!}
                </article>
                
            </div>
        </div>
    </div>
@endsection