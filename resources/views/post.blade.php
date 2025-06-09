@extends('layouts.main')

@section('container')
<div class="container my-4">

    {{-- Gambar & Deskripsi Post --}}
    <div class="card shadow-sm mb-4">
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
        @else
            <img src="https://picsum.photos/id/{{ $post->category->id }}/1200/400" alt="{{ $post->category->name }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
        @endif

        <div class="card-body">
            <h2 class="card-title">{{ $post->title }}</h2>
            <p class="text-muted">Kategori: 
            @foreach ($champs as $champ)    
                <span class="badge bg-secondary">{{ $champ->category->name }}</span>
            @endforeach   
            </p>
            <hr>
            <h5 class="mb-3">Deskripsi</h5>
            <article class="card-text fs-6">
                {!! $post->body !!}
            </article>
        </div>
    </div>

    {{-- Daftar Championship --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Daftar Championship</span>
            <span class="badge bg-light text-dark">{{ $champs->count() }} Total</span>
        </div>

    <!-- Perlu diedit menambah tombol daftar dan lihat -->
        <ul class="list-group list-group-flush">
            @forelse ($champs as $champ)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ url('/dashboard/champs/' . $champ->id . '/edit') }}" class="text-decoration-none text-dark fw-semibold">
                        {{ $champ->category->name ?? '-' }}
                    </a>
                    <span class="badge bg-info text-white">
                        {{ $champ->category->gender ?? '-' }}
                    </span>
                </li>
            @empty
                <li class="list-group-item text-muted">Tidak ada championship untuk turnamen ini.</li>
            @endforelse
        </ul>
    </div>

    {{-- Tombol Kembali --}}
    <div class="text-center">
        <a href="/blog" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Post Turnamen
        </a>
    </div>

</div>
@endsection
