@extends('dashboard.layouts.main')

@section('container')

<div class="pt-3 pb-2 mb-4 border-bottom mx-4">
  <h1 class="h2">Selamat Datang, {{ auth()->user()->name }}!</h1>
  <p class="text-muted fs-5">
    Senang melihatmu di <strong>TurneyGen Dashboard</strong> 🎉
  </p>
</div>

<div class="alert alert-info shadow-sm mx-4">
  <i class="bi bi-lightbulb-fill me-2"></i>
  <strong>Tips:</strong> Melalui dashboard ini, kamu bisa mengelola seluruh turnamenmu dengan mudah:
  <ul class="mb-0 mt-2">
    <li><strong>Mengelola Turnamen:</strong> Buat, edit, atau hapus turnamen sesuai keinginanmu.</li>
    <li><strong>Mengelola Bagan:</strong> Susun bagan pertandingan otomatis sesuai aturan PBSI.</li>
    <li><strong>Postingan :</strong> Publikasikan postingan untuk menarik peserta ke turnamenmu.</li>
    <br>
    <li><strong>Melihat Halaman Depan Web:</strong> Bisa klik icon namamu di pojok kanan atas.</li>
    <br>
    <img src="{{ asset('storage/tutorial/ke depan.png') }}" alt="" class="img-fluid rounded mb-3 shadow p-3 mb-5 bg-body rounded">
    <li><strong>Kembali ke Dashboard:</strong> Untuk kembali ke halaman Dashboard kamu bisa menggunakan cara yang sama.</li>
    <br>
    <img src="{{ asset('storage/tutorial/ke dash.png') }}" alt="" class="img-fluid rounded mb-3 shadow p-3 mb-5 bg-body rounded">
  </ul>
</div>

<div class="row g-4 my-4">

  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body text-center">
        <i class="bi bi-trophy-fill text-danger fs-1 mb-3"></i>
        <h5 class="card-title">Kelola Turnamen</h5>
        <p class="card-text text-muted">Buat turnamen baru atau kelola yang sudah ada. Tentukan kategori, jadwal, dan batas pendaftaran.</p>
        <a href="/dashboard/tours" class="btn btn-danger btn-sm">
          Lihat Turnamen
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body text-center">
        <i class="bi bi-diagram-3-fill text-success fs-1 mb-3"></i>
        <h5 class="card-title">Atur Bagan</h5>
        <p class="card-text text-muted">Susun bagan pertandingan secara otomatis agar turnamen berjalan lebih rapi dan adil.</p>
        <a href="/dashboard/champs" class="btn btn-success btn-sm">
          Kelola Bagan
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body text-center">
        <i class="bi bi-megaphone-fill text-info fs-1 mb-3"></i>
        <h5 class="card-title">Postingan</h5>
        <p class="card-text text-muted">Buat postingan menarik untuk mempromosikan turnamenmu dan menarik peserta lebih banyak.</p>
        <a href="/dashboard/posts" class="btn btn-info btn-sm text-white">
          Kelola Postingan
        </a>
      </div>
    </div>
  </div>

</div>

@endsection
