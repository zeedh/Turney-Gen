@extends('layouts.main')

@section('container')

<div class="container py-5 text-center">
    <h1 class="display-4 fw-bold mb-3">Selamat Datang di <span class="text-primary">TurneyGen</span> 🎉</h1>
    <p class="lead text-muted mb-4">
        Platform modern untuk membantu kamu <strong>membuat, mengelola,</strong> dan <strong>mempromosikan turnamen</strong> secara mudah
        sesuai aturan resmi PBSI.
    </p>

    <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-2">
        Mulai Sekarang
    </a>
    <a href="/blog" class="btn btn-outline-secondary btn-lg px-4">
        Lihat Postingan Turnamen
    </a>
</div>

<hr class="my-5">

<div class="container">
    <h2 class="text-center mb-5">Apa yang Bisa Kamu Lakukan di TurneyGen?</h2>
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-plus-circle-fill text-primary fs-1 mb-3"></i>
                    <h5 class="card-title">Buat Turnamen</h5>
                    <p class="card-text text-muted">
                        Mudah membuat turnamen dengan berbagai kategori, gender, dan batasan usia sesuai standar.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-gear-fill text-success fs-1 mb-3"></i>
                    <h5 class="card-title">Kelola Turnamen</h5>
                    <p class="card-text text-muted">
                        Atur jadwal, peserta, batas pendaftaran, dan semua detail turnamenmu hanya lewat dashboard.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-pencil-square text-warning fs-1 mb-3"></i>
                    <h5 class="card-title">Posting & Promosi</h5>
                    <p class="card-text text-muted">
                        Buat postingan menarik untuk mempromosikan turnamenmu dan menarik lebih banyak peserta.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-people-fill text-info fs-1 mb-3"></i>
                    <h5 class="card-title">Daftar Turnamen</h5>
                    <p class="card-text text-muted">
                        Peserta dapat mendaftar turnamen yang tersedia secara langsung di platform ini.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="bi bi-diagram-3-fill text-danger fs-1 mb-3"></i>
                    <h5 class="card-title">Atur Bagan</h5>
                    <p class="card-text text-muted">
                        Buat bagan pertandingan otomatis sesuai aturan PBSI, cepat dan tanpa ribet!
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<hr class="my-5">

<div class="container text-center mb-5">
    <h2 class="fw-bold">Mulai Kelola Turnamenmu Sekarang 🚀</h2>
    <p class="lead text-muted mb-4">
        Daftar akun, buat turnamen, atur bagan, dan promosikan pertandinganmu bersama TurneyGen!
    </p>
    <a href="/register" class="btn btn-primary btn-lg">
        Daftar Sekarang
    </a>
</div>

@endsection
