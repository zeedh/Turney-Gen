@extends('layouts.main')

@section('container')

    <div class="row justify-content-center my-4">
        <div class="col-md-6">
            <form action="/blog">

                @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                @if (request('author'))
                <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                
                <div class="input-group mb-6">
                    <input type="text" class="form-control" placeholder="Cari Turnamen.." name="search" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    @if ($posts->count())
    <div class="card mb-3">
        @if($posts[0]->image)
            <img src="{{ asset('storage/'.$posts[0]->image) }}" class="img-fluid mt-3">
        @else
        <img src="https://picsum.photos/id/{{$posts[0]->category->id}}/1200/400" class="card-img-top" alt="{{$posts[0]->category->name}}">
        @endif         
        
        <div class="card-body text-center">
            <h3 class="card-title"><a href="/blog/{{ $posts[0]->slug }}" class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
            <p><small class="text-body-secondary">Oleh : 
                <a href="/blog?author={{ $posts[0]->author->username }}" class="text-decoration-none">{{ $posts[0]->author->name }}</a> <br>
                Kategori :
                <a href="/blog?category={{ $posts[0]->category->slug }}" class="text-decoration-none">{{ $posts[0]->category->name }} </a> <br>
                {{ $posts[0]->created_at->diffForHumans() }}</small>
            </p>
            <p class="card-text">{{ $posts[0]->excerpt }}</p>

            <a href="/blog/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Lihat Selengkapnya</a>
        </div>
    </div>

    

    <div class="container">
        <div class="row">
            @foreach ($posts->skip(1) as $post)
            <div class="col-md-4 mb-3">
                <div class="card" style="width: 18rem;">
                    <div class="position-absolute bg-dark px-3 py-2">
                        <a href="/blog?category={{ $post->category->slug }}" class="text-white text-decoration-none">{{$post->category->name}}</a>
                    </div>
                    @if($post->image)
                    <img src="{{ asset('storage/'.$post->image) }}" class="img-fluid mt-3">
                @else
                <img src="https://picsum.photos/id/{{$post->category->id}}/500" class="card-img-top" alt="{{$post->category->name}}">
                @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p><small class="text-body-secondary">Oleh : 
                            <a href="/blog?author={{ $posts[0]->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a>
                            {{ $post->created_at->diffForHumans() }}</small>
                        </p>
                        <p class="card-text">{{ $post->excerpt }}</p>
                        <a href="/blog/{{ $post->slug }}" class="btn btn-primary">Lihat Selengkapnya</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @else
    <p class="text-center fs-6">Postingan Turnamen tidak ditemukan</p>

    @endif
    
    <div class="d-flex justify-content-center p-3">
        {{ $posts->links() }}
    </div>
    

@endsection

