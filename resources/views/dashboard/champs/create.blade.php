@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
  <h2 class="fw-bold">
      Buat Bagan, {{ auth()->user()->name }}!
  </h2>
</div>

<div class="card shadow-sm col-lg-8">
  <div class="card-body">
    <form method="POST" action="/dashboard/champs" enctype="multipart/form-data">
      @csrf

      {{-- Turnamen --}}
      <div class="mb-3">
        <label for="tournament_id" class="form-label">Pilih Turnamen</label>
        <select class="form-select @error('tournament_id') is-invalid @enderror" name="tournament_id" id="tournament_id" required>
          <option selected disabled>-- Pilih Turnamen --</option>
          @foreach($tours as $tour)
            <option value="{{ $tour->id }}" {{ old('tournament_id') == $tour->id ? 'selected' : '' }}>
              {{ $tour->name }}
            </option>
          @endforeach
        </select>
        @error('tournament_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Kategori --}}
      <div class="mb-3">
        <label for="category_id" class="form-label">Pilih Kategori</label>
        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id" required>
          <option selected disabled>-- Pilih Kategori --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }} ({{ ucfirst($category->gender) }})
            </option>
          @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Jumlah Peserta --}}
      <div class="mb-3">
        <label for="limitByEntity" class="form-label">Maksimal Jumlah Peserta</label>
        <input type="number" class="form-control @error('limitByEntity') is-invalid @enderror" id="limitByEntity" name="limitByEntity" min="4" max="128" value="{{ old('limitByEntity') ?? 8 }}" required>
        @error('limitByEntity') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Jenis Pertandingan --}}
    <input type="hidden" name="isTeam" id="isTeam" value="0">

    {{-- Preliminary --}}
    <input type="hidden" name="hasPreliminary" id="hasPreliminary" value="0">

    {{-- Ukuran Grup Penyisihan --}}
    <input type="hidden" name="preliminaryGroupSize" id="preliminaryGroupSize" value="0">

    {{-- Jenis Tree --}}
    <div class="mb-3">
      <label for="treeType" class="form-label">
        Tipe Bagan Pertandingan 
        <small class="text-muted d-block">*Belum bisa memilih karena sedang dalam pengembangan</small>
      </label>

      {{-- Disabled select (untuk ditampilkan saja) --}}
      <select class="form-select" id="treeType_display" disabled>
        <option value="0">Playoff / Round Robin</option>
        <option value="1" selected>Single Elimination</option>
      </select>

      {{-- Hidden input agar tetap terkirim ke server --}}
      <input type="hidden" name="treeType" value="1">

      @error('treeType') 
        <div class="invalid-feedback d-block">{{ $message }}</div> 
      @enderror
    </div>

      <!-- {{-- Apakah Beregu? --}}
      <div class="mb-3">
        <label for="isTeam" class="form-label">Jenis Pertandingan</label>
        <select class="form-select @error('isTeam') is-invalid @enderror" name="isTeam" id="isTeam" required>
          <option value="0" {{ old('isTeam') == '0' ? 'selected' : '' }}>Individu</option>
          <option value="1" {{ old('isTeam') == '1' ? 'selected' : '' }}>Tim / Beregu</option>
        </select>
        @error('isTeam') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Preliminary --}}
      <div class="mb-3">
        <label for="hasPreliminary" class="form-label">Ada Babak Penyisihan?</label>
        <select class="form-select @error('hasPreliminary') is-invalid @enderror" name="hasPreliminary" id="hasPreliminary" required>
          <option value="0" {{ old('hasPreliminary') == '0' ? 'selected' : '' }}>Tidak</option>
          <option value="1" {{ old('hasPreliminary') == '1' ? 'selected' : '' }}>Ya</option>
        </select>
        @error('hasPreliminary') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Ukuran Grup Penyisihan --}}
      <div class="mb-3">
        <label for="preliminaryGroupSize" class="form-label">Ukuran Grup Penyisihan (jika ada)</label>
        <select class="form-select @error('preliminaryGroupSize') is-invalid @enderror" name="preliminaryGroupSize" id="preliminaryGroupSize">
          <option selected disabled>-- Pilih Ukuran Grup --</option>
          @foreach([3, 4, 5] as $size)
            <option value="{{ $size }}" {{ old('preliminaryGroupSize') == $size ? 'selected' : '' }}>{{ $size }} Peserta per grup</option>
          @endforeach
        </select>
        @error('preliminaryGroupSize') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Jenis Tree --}}
      <div class="mb-3">
        <label for="treeType" class="form-label">Tipe Bagan Pertandingan</label>
        <select class="form-select @error('treeType') is-invalid @enderror" name="treeType" id="treeType" required>
          <option value="0" {{ old('treeType') == '0' ? 'selected' : '' }}>Playoff / Round Robin</option>
          <option value="1" {{ old('treeType') == '1' ? 'selected' : '' }}>Single Elimination</option>
        </select>
        @error('treeType') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div> -->

      {{-- Jumlah Arena --}}
      <div class="mb-3">
        <label for="fightingAreas" class="form-label">Jumlah Arena Bertanding</label>
        <select class="form-select @error('fightingAreas') is-invalid @enderror" name="fightingAreas" id="fightingAreas" required>
          @foreach([1, 2, 4, 8] as $arena)
            <option value="{{ $arena }}" {{ old('fightingAreas') == $arena ? 'selected' : '' }}>{{ $arena }} Arena</option>
          @endforeach
        </select>
        @error('fightingAreas') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-success mt-4">
        <i class="bi bi-plus-circle me-1"></i> Buat Bagan
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const hasPreliminary = document.getElementById('hasPreliminary');
    const preliminaryGroupSize = document.getElementById('preliminaryGroupSize');

    function toggleGroupSize() {
      if (hasPreliminary.value === '1') {
        preliminaryGroupSize.removeAttribute('disabled');
      } else {
        preliminaryGroupSize.setAttribute('disabled', true);
        preliminaryGroupSize.selectedIndex = 0; // reset ke default
      }
    }

    hasPreliminary.addEventListener('change', toggleGroupSize);

    // Jalankan sekali saat halaman load
    toggleGroupSize();
  });
</script>
@endpush

@endsection
