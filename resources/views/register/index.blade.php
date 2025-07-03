@extends('layouts.main')

@section('container')
<div class="container my-5">
    <h1 class="text-center mb-4 text-primary">Registrasi</h1>

    <div class="row justify-content-center g-4">
        
        <!-- Card Panitia -->
        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-body mx-3">
                    <h4 class="card-title text-success border-bottom pb-2 mb-3">Daftar sebagai Panitia</h4>
                    <ul class="mb-3 ps-3">
                        <li>Membuat turnamen</li>
                        <li>Membuat bagan pertandingan</li>
                        <li>Membuat postingan turnamen</li>
                    </ul>
                    <a href="{{ url('/register/panitia') }}" class="btn btn-success">Daftar Panitia</a>
                </div>
            </div>
        </div>

        <!-- Card Peserta -->
        <div class="col-md-5">
            <div class="card shadow-sm h-100">
                <div class="card-body mx-3">
                    <h4 class="card-title text-primary border-bottom pb-2 mb-3">Daftar sebagai Peserta</h4>
                    <ul class="mb-3 ps-3">
                        <li>Mendaftar turnamen</li>
                        <li>Melihat bagan pertandingan</li>
                        <li>Melihat postingan turnamen</li>
                    </ul>
                    <a href="{{ url('/register/peserta') }}" class="btn btn-primary">Daftar Peserta</a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
