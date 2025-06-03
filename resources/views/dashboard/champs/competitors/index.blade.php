@extends('dashboard.champs.layouts.main')

@section('container')
    <h2>Peserta untuk Turnamen: {{ $champ->name }}</h2>

    <form action="{{ route('competitors.index', ['champ' => $champ->id]) }}" method="GET" class="mb-3">
        <div class="input-group col-lg-8">
            <input type="text" name="search" class="form-control" placeholder="Cari user..." value="{{old('search'), request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
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
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>
                    "{{ $comp->user->firstname }}" - {{ $comp->user->name }}
                </span>

                <div class="btn-group">
                    <!-- Tombol Hapus Peserta -->
                    <form action="{{ route('competitors.destroy', [$champ->id, $comp->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peserta ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p>Belum ada peserta.</p>
@endif


@endsection