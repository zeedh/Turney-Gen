@extends('layouts.main')

@section('container')
<div class="container">
    <h1>Profil Saya</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body m-3">
            @if(auth()->user()->image)
                <img src="{{ $user->image ? url('/profile-image/' . basename($user->image)) : asset('default-profile.png') }}"
                    alt="Profile Image" width="200" class="img-thumbnail mb-3">
            @else
                <i class="bi bi-person-circle fs-1 mb-3" ></i>
            @endif

            <p><strong>Nama Lengkap:</strong> {{ $user->firstname }} {{ $user->lastname }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $user->birthDate->format('d M Y') }}</p>

            <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
