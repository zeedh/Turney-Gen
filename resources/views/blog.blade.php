@extends('layouts.main')

@section('container')
<style>
    img.object-fit-cover {
        object-fit: cover;
    }
</style>


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
<div class="container mb-3">
    <div class="ratio ratio-16x9 rounded overflow-hidden" style="max-width: 900px; margin: auto;">
        @if($posts[0]->image)
            <img src="{{ url('/post-image/' . basename($posts[0]->image)) }}"
                 class="w-100 h-100 object-fit-cover"
                 alt="Post Image"
                 style="object-fit: cover;">
        @else
            <img src="https://picsum.photos/id/{{$posts[0]->category->id}}/900/400"
                 class="w-100 h-100 object-fit-cover"
                 alt="{{ $posts[0]->category->name }}"
                 style="object-fit: cover;">
        @endif
    </div>
</div>

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
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @foreach ($posts->skip(1) as $post)
        <div class="col">
            <div class="card h-100">
                <div class="position-absolute bg-dark px-3 py-2">
                    <a href="/blog?category={{ $post->category->slug }}" class="text-white text-decoration-none">
                        {{ $post->category->name }}
                    </a>
                </div>

                @if($post->image)
                    <div class="ratio ratio-16x9">
                        <img src="{{ url('/post-image/' . basename($post->image)) }}"
                             class="card-img-top object-fit-cover"
                             alt="Gambar {{ $post->category->name }}"
                             style="object-fit: cover;">
                    </div>
                @else
                    <img src="https://picsum.photos/id/{{$post->category->id}}/500"
                         class="card-img-top object-fit-cover"
                         alt="{{ $post->category->name }}"
                         style="object-fit: cover;">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p><small class="text-body-secondary">Oleh: 
                        <a href="/blog?author={{ $post->author->username }}" class="text-decoration-none">
                            {{ $post->author->name }}
                        </a>
                        {{ $post->created_at->diffForHumans() }}</small>
                    </p>
                    <p class="card-text">{{ $post->excerpt }}</p>
                    <a href="/blog/{{ $post->slug }}" class="btn btn-primary mt-auto">Lihat Selengkapnya</a>
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

