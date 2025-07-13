@extends('dashboard.layouts.main')

@section('container')
<div class="container my-4">
            <div class="mb-4 d-flex justify-content-between align-items-center">
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

    {{-- Gambar & Deskripsi Post --}}
    <div class="card shadow-sm mb-4">
        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
        @else
            <img src="https://picsum.photos/id/{{ $post->category->id }}/1200/400" alt="{{ $post->category->name }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
        @endif

        <div class="card-body">
            <h2 class="card-title text-center mb-4">{{ $post->title }}</h2>

            {{-- Daftar Championship --}}
            <div class="card shadow-sm mb-4 mx-auto" style="max-width: 800px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-trophy-fill me-2"></i> Detail Turnamen</span>
                </div>

                <ul class="list-group list-group-flush">
                    @forelse ($champs as $champ)
                        <li class="list-group-item">
                            <div class="row g-3 align-items-center">

                                {{-- KIRI: Nama, gender, status --}}
                                <div class="col-md-8">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <a
                                           class="text-decoration-none text-dark fw-semibold">
                                            Kategori: {{ $champ->category->name ?? '-' }}
                                        </a>

                                        <span class="badge bg-info text-white">
                                            <i class="bi bi-gender-ambiguous me-1"></i>
                                            {{ $champ->category->gender ?? '-' }}
                                        </span>

                                        @auth
                                            @if (in_array($champ->id, $competitorChampionshipIds))
                                                <span class="badge bg-success text-white">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Sudah terdaftar
                                                </span>
                                            @endif
                                        @endauth
                                    </div>

                                    {{-- Info Waktu --}}
                                    <div class="mt-2">
                                        <span class="badge bg-secondary me-2">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            Waktu Penyelenggaraan :
                                            {{ $tour->dateIni ?? '-' }} s.d. {{ $tour->dateFin ?? '-' }}
                                        </span>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock-fill me-1"></i>
                                            Batas Daftar: {{ $tour->registerDateLimit ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- KANAN: Tombol aksi --}}
                                <div class="col-md-4 text-md-end mb-3">
                                    <span class="text-muted small d-block mb-2">Turnamen belum dimulai</span>
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-circle me-1"></i> Daftar
                                    </button>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">
                            Tidak ada championship untuk turnamen ini.
                        </li>
                    @endforelse
                </ul>
            </div>

            <hr class="my-4">

            <h5 class="mb-3 text-primary text-center"><i class="bi bi-info-circle-fill me-2"></i>Deskripsi</h5>
            <article class="card-text fs-6">
                {!! $post->body !!}
            </article>
        </div>
    </div>

</div>
@endsection
