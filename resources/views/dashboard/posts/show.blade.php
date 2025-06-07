@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <div class="row my-4 justify-content-center">
        <div class="col-lg-9">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold">{{ $post->title }}</h2>
                <div>
                    <a href="/dashboard/posts" class="btn btn-outline-success me-2">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-outline-warning me-2">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button class="btn btn-outline-danger" onclick="return confirm('Yakin ingin menghapus postingan ini?')">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                @else
                    <img src="https://picsum.photos/id/{{ $post->category->id }}/1200/400" alt="{{ $post->category->name }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <h5 class="card-title mb-3">Deskripsi</h5>
                    <article class="card-text fs-6">
                        {!! $post->body !!}
                    </article>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Daftar Championship</span>
                    <span class="badge bg-light text-dark">{{ $champs->count() }} total</span>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($champs as $champ)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ url('/dashboard/champs/' . $champ->id . '/edit') }}" class="text-decoration-none">
                                {{ $champ->category->name ?? '-' }}
                            </a>
                            <span class="badge bg-secondary rounded-pill">
                                {{ $champ->category->gender ?? '-' }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Tidak ada championship untuk turnamen ini.</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection
