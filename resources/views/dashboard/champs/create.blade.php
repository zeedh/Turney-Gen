@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
  <h2 class="fw-bold">
    <i class="bi bi-trophy-fill me-2 text-warning"></i>
     Buat Championship Baru, {{ auth()->user()->name }}!
  </h2>
</div>

<div class="card shadow-sm col-lg-8">
  <div class="card-body">
    <form method="POST" action="/dashboard/champs" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="tournament_id" class="form-label">Pilih Turnamen</label>
        <select class="form-select @error('tournament_id') is-invalid @enderror" name="tournament_id" id="tournament_id">
          <option selected disabled>-- Pilih Turnamen --</option>
          @foreach($tours as $tour)
            <option value="{{ $tour->id }}" {{ old('tournament_id') == $tour->id ? 'selected' : '' }}>
              {{ $tour->name }}
            </option>
          @endforeach
        </select>
        @error('tournament_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="mb-3">
        <label for="category_id" class="form-label">Pilih Kategori</label>
        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
          <option selected disabled>-- Pilih Kategori --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-success mt-3">
        <i class="bi bi-plus-circle me-1"></i> Buat Championship
      </button>
    </form>
  </div>
</div>
@endsection
