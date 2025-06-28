@extends('layouts.main')

@section('title', 'About Zidan Dhiyaul Haq')

@section('container')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <img src="https://source.unsplash.com/120x120/?profile,man" 
                 alt="Zidan Dhiyaul Haq" 
                 class="rounded-circle mb-4 shadow-sm">
            <h1 class="display-4 fw-bold">Zidan Dhiyaul Haq</h1>
            <p class="lead text-muted">
                Mahasiswa <strong>Teknik Informatika</strong> di 
                <span class="text-primary fw-semibold">Universitas Muhammadiyah Surakarta</span>,
                dengan semangat membangun solusi digital yang bermanfaat.
            </p>
            <!-- <a href="#" class="btn btn-primary mt-3">
                Lihat Karya Saya
            </a> -->
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Background</h5>
                    <p class="card-text">
                        Saat ini sedang menempuh studi Teknik Informatika di UMS.
                        Saya tertarik pada dunia teknologi dan inovasi digital.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-code-slash display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Skills & Interests</h5>
                    <p class="card-text">
                        Saya menyukai coding, problem solving, serta belajar teknologi baru.
                        Fokus saya di backend development, web apps, dan user experience.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-bullseye display-4 text-primary mb-3"></i>
                    <h5 class="card-title">Vision</h5>
                    <p class="card-text">
                        Target saya menjadi backend developer profesional
                        dan berkontribusi membangun software yang impactful
                        untuk kehidupan dan bisnis.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <div class="text-center">
        <h5 class="mb-3">Contact & Social Media</h5>
        <div class="d-flex justify-content-center gap-3">
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
