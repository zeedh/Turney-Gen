@extends('dashboard.layouts.main')

@section('container')
<div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h2>{{ $post->title }} </h2>
                <a href="/dashboard/posts" class="btn btn-success">Back to all My Posts</a>
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

                <h4>Daftar Championship</h4>

                @if($champs->isEmpty())
                <p>Tidak ada championship untuk turnamen ini.</p>
                @else
                <ul class="list-group mb-3">
                    @foreach ($champs as $champ)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="{{ url('/dashboard/champs/' . $champ->id . '/edit') }}" class="text-decoration-none">
                        {{ $champ->category->name  }}
                        </a>
                        <span class="badge bg-primary rounded-pill">
                        {{ $champ->category->name ?? '-' }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @endif



                <article class="my-3 fs-6">
                    {!! $post->body !!}
                </article>
                
            </div>
        </div>
    </div>
@endsection