@extends('dashboard.layouts.main')

@section('container')
<div class="container">
    <h1>Edit Profil</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="firstname" class="form-label">Nama Depan</label>
            <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                   id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}">
            @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Nama Belakang</label>
            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                   id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}">
            @error('lastname') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="birthDate" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control @error('birthDate') is-invalid @enderror"
                   id="birthDate" name="birthDate" value="{{ old('birthDate', $user->birthDate->format('Y-m-d')) }}">
            @error('birthDate') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Foto Profil</label>
            @if ($user->image)
                <img src="{{ asset('storage/'.$user->image) }}" width="100" class="img-thumbnail d-block mb-2">
            @endif
            <input type="file" class="form-control @error('image') is-invalid @enderror"
                   id="image" name="image">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('profile.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
