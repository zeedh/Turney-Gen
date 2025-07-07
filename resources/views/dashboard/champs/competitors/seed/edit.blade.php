@extends('dashboard.champs.layouts.main')

@section('container')
<div class="card shadow-sm p-4 mt-4 col-lg-8 mx-auto">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Update Seed untuk Turnamen "{{ $champ->tournament->name }}"</h4>
        <a href="{{ route('dashboard.competitors.index', $champ->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Peserta
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('dashboard.competitors.seed.save', $champ->id) }}">
        @csrf

        <div class="row fw-bold border-bottom pb-2 mb-2">
            <div class="col-8">Nama Peserta</div>
            <div class="col-4">Seed</div>
        </div>

        @forelse($competitors as $comp)
            <div class="row align-items-center mb-3">
                <div class="col-8">
                    {{ $comp->user->firstname }} - {{ $comp->user->name }}
                </div>
                <div class="col-4">
                    <input type="number" name="seeds[{{ $comp->id }}]" value="{{ $comp->seed }}" class="form-control" min="1">
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada peserta terdaftar.</p>
        @endforelse

        <div class="mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check2-circle me-1"></i> Simpan Seed
            </button>
        </div>
    </form>
</div>
@endsection
