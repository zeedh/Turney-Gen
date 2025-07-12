@extends('layouts.main')

@section('title', 'About Zidan Dhiyaul Haq')

@section('container')
<div class="container py-5">

    {{-- Heading Halaman --}}
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">About TurneyGen</h1>
        <p class="lead text-muted">
            TurneyGen adalah aplikasi untuk membantu membuat turnamen secara mudah, cepat, 
            dan sesuai regulasi resmi PBSI.
        </p>
    </div>

    {{-- Info Tentang Proyek Skripsi --}}
    <div class="alert alert-primary text-center shadow-sm">
        <i class="bi bi-info-circle-fill me-2"></i>
        Aplikasi generator turnamen otomatis sesuai aturan PBSI ini merupakan <strong>proyek skripsi</strong>.
        <h5><strong>Oleh : </strong></h5>
    </div>

    {{-- Foto Profil dan Identitas --}}
    <div class="row justify-content-center my-5">
        <div class="col-lg-8 text-center">
            <img src="{{ asset('storage/tutorial/PP1.jpg') }}"
                alt="Zidan Dhiyaul Haq"
                class="rounded-circle mb-4 shadow-lg border border-3 border-primary"
                width="180" height="180" style="object-fit: cover;">
            <h2 class="fw-bold mb-2">Zidan Dhiyaul Haq</h2>
            <p class="lead text-muted">
                Mahasiswa <strong>Teknik Informatika</strong> di
                <span class="text-primary fw-semibold">Universitas Muhammadiyah Surakarta</span>,
                bersemangat menciptakan solusi digital yang bermanfaat.
            </p>
            {{-- Tombol Portofolio --}}
            {{-- <a href="#" class="btn btn-primary mt-3">Lihat Karya Saya</a> --}}
        </div>
    </div>

    {{-- Card Info Personal --}}
    <div class="row g-4">
        <div class="col-md-4 text-center">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Background</h5>
                    <p class="card-text">
                        Saat ini menempuh studi Teknik Informatika di UMS. Tertarik
                        dengan inovasi teknologi dan solusi digital yang berdampak.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-code-slash display-4 text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Skills & Interests</h5>
                    <p class="card-text">
                        Passion di coding, problem solving, dan teknologi baru.
                        Fokus pada backend development, web apps, dan user experience.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-bullseye display-4 text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Vision</h5>
                    <p class="card-text">
                        Berambisi menjadi backend developer profesional dan
                        menciptakan software yang bermanfaat bagi kehidupan dan bisnis.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    {{-- Sosial Media --}}
    <div class="text-center">
        <h5 class="fw-bold mb-3">Contact & Social Media</h5>
        <div class="d-flex justify-content-center gap-4">
            <a href="https://instagram.com/username" target="_blank" class="text-decoration-none text-dark">
                <i class="bi bi-instagram fs-3"></i>
            </a>
            <a href="https://github.com/username" target="_blank" class="text-decoration-none text-dark">
                <i class="bi bi-github fs-3"></i>
            </a>
            <a href="https://linkedin.com/in/username" target="_blank" class="text-decoration-none text-dark">
                <i class="bi bi-linkedin fs-3"></i>
            </a>
        </div>
    </div>

</div>
@endsection
