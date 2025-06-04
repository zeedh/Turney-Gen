@extends('dashboard.champs.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
  <h2 class="fw-bold">
    <i class="bi bi-diagram-3-fill me-2 text-primary px-4"></i>
    Edit Bagan Turnamen
  </h2>
</div>

<div class="card shadow-sm col-lg-8">
  <div class="card-body">
    <form action="/dashboard/champs/{{ $champ->id }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

    <div class="mb-4 pt-2">
    <label class="form-label fw-semibold">Turnamen</label>
    <input type="text" class="form-control-plaintext bg-light px-3 py-2 my-2 fw-semibold text-dark rounded" 
            value="{{ $tours->firstWhere('id', $champ->tournament_id)->name }}" readonly>
    <input type="hidden" name="tournament_id" value="{{ $champ->tournament_id }}">
    </div>


      <div class="mb-3">
        <label for="category_id" class="form-label fw-semibold">Kategori</label>
        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
          <option disabled selected>-- Pilih Kategori --</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $champ->category_id) == $category->id ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-success mt-3">
        <i class="bi bi-save me-1"></i> Simpan Perubahan
      </button>
    </form>
  </div>
</div>
@endsection
