@extends('dashboard.champs.layouts.main')

@section('container')
    <h2>Peserta untuk Turnamen: {{ $champ->name }}</h2>

    <form action="{{ route('competitors.index', ['champ' => $champ->id]) }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari user..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    {{-- HASIL USER YANG DITEMUKAN --}}
    @if(request('search'))
        <h5>Hasil pencarian untuk: "{{ request('search') }}"</h5>

        @if($users->count())
            <ul class="list-group mt-3">
                @foreach($users as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $user->name }} ({{ $user->email }})
                        <form action="{{ route('competitors.store', ['champ' => $champ->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="championship_id" value="{{ $champ->id }}">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button class="btn btn-sm btn-primary">Tambah</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted mt-3">Tidak ada user ditemukan.</p>
        @endif
    @endif

    <h4>Daftar Peserta Turnamen "{{ $champ->tournament->name }}"</h4>
    @if($competitors->count())
        <ul class="list-group">
            @foreach($competitors as $comp)
                <li class="list-group-item">
                    "{{ $comp->user->firstname }}" - {{ $comp->user->name }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Belum ada peserta.</p>
    @endif


@endsection