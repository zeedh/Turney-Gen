
@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>{{ $post->title }} </h2>
                <p>By : 
                    <a href="/blog?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> in 
                    <a href="/blog?category={{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->name }} </a> 
                </p>
                
                <img src="https://picsum.photos/id/{{$post->category->id}}/1200/400" alt="{{ $post->category->name }}" 
                class="img-fluid">

                <article class="my-3 fs-6">
                    {!! $post->body !!}
                </article>
                

                <a href="/blog"> Kembali ke Blog</a>
            </div>
        </div>
    </div>
        

@endsection