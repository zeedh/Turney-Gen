@extends('layouts.main')

@section('container')
<div class="container my-4">
        {{-- Tombol Kembali --}}
    <div class=" my-4">
        <a href="/blog" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
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
                                        <a href="{{ url('/dashboard/champs/' . $champ->id . '/edit') }}"
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
                                    @if ($champ->fightersGroups()->count() === 0)
                                        <span class="text-muted small d-block mb-2">Turnamen belum dimulai</span>

                                        {{-- Tombol daftar/batal --}}
                                        @auth
                                            @if (in_array($champ->id, $competitorChampionshipIds))
                                                <form action="{{ route('blog.destroy', ['post' => $post->slug]) }}" method="POST" onsubmit="return confirm('Yakin batal daftar?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="championship_id" value="{{ $champ->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-x-circle me-1"></i> Batal Daftar
                                                    </button>
                                                </form>
                                            @else
                                                @php
                                                    $user = auth()->user();
                                                    $userGender = $user->gender ?? null;
                                                    $categoryGender = $champ->category->gender ?? 'X';

                                                    $birthDate = $user->birthDate ?? null;
                                                    $userAge = $birthDate ? \Carbon\Carbon::parse($birthDate)->age : null;

                                                    $ageMin = $champ->category->ageMin ?? 0;
                                                    $ageMax = $champ->category->ageMax ?? 200;

                                                    $isGenderAllowed = $categoryGender === 'X' || $categoryGender === $userGender;
                                                    $isAgeAllowed = is_null($userAge) ? false : ($userAge >= $ageMin && $userAge <= $ageMax);
                                                @endphp

                                                @if ($isGenderAllowed && $isAgeAllowed)
                                                    <form action="{{ route('blog.store', ['post' => $post->slug]) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="championship_id" value="{{ $champ->id }}">
                                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="bi bi-check-circle me-1"></i> Daftar
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-danger small d-block">
                                                        Tidak bisa mendaftar.
                                                    </span>
                                                    @unless($isGenderAllowed)
                                                        <span class="text-danger small">
                                                            Kategori ini hanya untuk
                                                            <strong>{{ $categoryGender === 'M' ? 'Laki-laki' : ($categoryGender === 'F' ? 'Perempuan' : 'Campuran') }}</strong>.
                                                        </span>
                                                    @endunless
                                                    @unless($isAgeAllowed)
                                                        <span class="text-danger small">
                                                            Usia Anda tidak memenuhi syarat ({{ $ageMin }} - {{ $ageMax }} tahun).
                                                        </span>
                                                    @endunless
                                                @endif
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Mendaftar
                                            </a>
                                        @endauth
                                    @else
                                        <span class="text-muted small d-block mb-2">Turnamen sudah dimulai</span>
                                        <a href="/dashboard/champs/{{ $champ->id }}/setting/{{ $champ->settings->id }}"
                                           class="btn btn-success btn-sm">
                                            <i class="bi bi-eye-fill me-1"></i> Lihat Tree
                                        </a>
                                    @endif
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
