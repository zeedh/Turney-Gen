@extends('dashboard.champs.layouts.main')

@section('container')
    <!-- <h2>Peserta Turnamen: {{ $champ->tournament->name }} untuk kategori {{ $champ->category->name }}</h2> -->
    <div class="card shadow-sm col-lg-8 p-3 mt-3 mb-4">

            <form action="{{ route('competitors.index', ['champ' => $champ->id]) }}" method="GET" class="mb-3">
                <div class="input-group col-lg-8">
                    <input type="text" name="search" class="form-control" placeholder="Cari user..." value="{{old('search'), request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Cari</button>
                </div>
            </form>

            {{-- HASIL USER YANG DITEMUKAN --}}
            <div class="my-3">
                @if(request('search'))
                    <h5>Hasil pencarian untuk: "{{ request('search') }}"</h5>

                    @if($users->count())
                    <ul class="list-group mt-3">
                        @foreach($users as $user)
                            @php
                                $isRegistered = $competitors->contains('user_id', $user->id);
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $user->name }} ({{ $user->email }})
                                </div>

                                @if($isRegistered)
                                    <span class="badge bg-success p-2">Terdaftar</span>
                                @else
                                    <form action="{{ route('competitors.store', ['champ' => $champ->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="championship_id" value="{{ $champ->id }}">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button class="btn btn-sm btn-primary">Tambah</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <!-- PAGINATION -->
                    <div class="mt-3 d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>

                    @else
                        <p class="text-muted mt-3">Tidak ada user ditemukan.</p>
                    @endif
                @endif
            </div>


            <h4>Daftar Peserta Turnamen "{{ $champ->tournament->name }}"</h4>
            <p>Total Peserta: {{ $competitors->count() }}</p>

            @if($competitors->count())
                <ul class="list-group">
                    <li class="list-group-item bg-light fw-bold">
                        <div class="row text-center">
                            <div class="col-1">#</div>
                            <div class="col-6 text-start">Nama Peserta</div>
                            <div class="col-2">Seed</div>
                            <div class="col-3">Aksi</div>
                        </div>
                    </li>

                    @foreach($competitors as $index => $comp)
                        <li class="list-group-item">
                            <div class="row align-items-center text-center">
                                <div class="col-1 fw-semibold">{{ $index + 1 }}</div>
                                <div class="col-6 text-start">"{{ $comp->user->firstname }}" - {{ $comp->user->name }}</div>
                                <div class="col-2">
                                    <span class="badge bg-secondary">{{ $comp->seed ?? '-' }}</span>
                                </div>
                                <div class="col-3">
                                    <form action="{{ route('competitors.destroy', [$champ->id, $comp->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus peserta ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>


            @else
                <p class="text-muted">Belum ada peserta.</p>
            @endif


        <a href="{{ route('competitors.seed.edit', $champ->id) }}" class="btn btn-outline-secondary mt-3">
            Edit Seed
        </a>

    </div>


@endsection