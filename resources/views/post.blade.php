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
            <h2 class="card-title mx-3 justify-content-center">{{ $post->title }}</h2>

            {{-- Daftar Championship --}}
            <div class="card shadow-sm mb-4 col-lg-6">
                <ul class="list-group list-group-flush my-3">
                    @forelse ($champs as $champ)
                        <li class="list-group-item">
                            <div class="row align-items-center text-center">

                                {{-- KIRI: Nama, gender, status --}}
                                <div class="col-md-8 d-flex align-items-center justify-content-center justify-content-md-start flex-wrap gap-2">
                                    <a href="{{ url('/dashboard/champs/' . $champ->id . '/edit') }}"
                                       class="text-decoration-none text-dark fw-semibold mx-1">
                                        Kategori: {{ $champ->category->name ?? '-' }}
                                    </a>
                                    <span class="badge bg-info text-white">
                                        {{ $champ->category->gender ?? '-' }}
                                    </span>

                                    @auth
                                        @if (in_array($champ->id, $competitorChampionshipIds))
                                            <span class="text-success small fw-semibold mx-1">
                                                Sudah terdaftar
                                            </span>
                                        @endif
                                    @endauth
                                </div>

                                {{-- KANAN: Tombol aksi --}}
                                <div class="col-md-4 mt-3 mt-md-0 d-flex flex-column gap-2 align-items-center justify-content-center justify-content-md-end">

                                    {{-- Tombol Lihat Tree --}}
                                    @if ($champ->fightersGroups()->count() === 0)
                                        <span class="text-muted small">Turnamen belum dimulai</span>
                                        {{-- Tombol daftar/batal --}}
                                        @auth
                                            @if (in_array($champ->id, $competitorChampionshipIds))
                                                <form action="{{ route('blog.destroy', ['post' => $post->slug]) }}" method="POST" onsubmit="return confirm('Yakin batal daftar?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="championship_id" value="{{ $champ->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Batal Daftar
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('blog.store', ['post' => $post->slug]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="championship_id" value="{{ $champ->id }}">
                                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Daftar
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                                                Login untuk Mendaftar
                                            </a>
                                        @endauth
                                    @else
                                        <span class="text-muted small">Turnamen sudah dimulai</span>
                                        <a href="{{ route('bagan.index', ['champ' => $champ->id]) }}"
                                        class="btn btn-success btn-sm">
                                            Lihat Tree
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">
                            Tidak ada championship untuk turnamen ini.
                        </li>
                    @endforelse
                </ul>
            </div>

            <hr>
            <h5 class="mb-3 mx-3">Deskripsi</h5>
            <article class="card-text fs-6 m-3">
                {!! $post->body !!}
            </article>
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="text-center">
        <a href="/blog" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

</div>
@endsection
