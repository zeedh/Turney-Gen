@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
  <h2 class="fw-bold">Buat Turnamen Anda, {{ auth()->user()->name }}!</h2>
</div>

<div class="card shadow-sm col-lg-8">
  <div class="card-body">
    <form method="POST" action="/dashboard/tours" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Judul Turnamen</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror"
               id="name" name="name" required autofocus value="{{ old('name') }}">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="mb-3">
        <label for="slug" class="form-label">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror"
               id="slug" name="slug" required value="{{ old('slug') }}">
        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <!-- <div class="mb-3">
        <label for="category_id" class="form-label">Kategori</label>
        <select class="form-select" name="category_id" id="category_id">
          @foreach($categories as $category)
            <option value="{{ $category->id }}"
              {{ (old('category_id', 1) == $category->id) ? 'selected' : '' }}>
              {{ $category->name }}
            </option>
          @endforeach
        </select>
      </div> -->
      <input type="hidden" id="category_id" name="category_id" value="{{ old('category_id', $defaultCategoryId) }}">


      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="dateIni" class="form-label">Tanggal Mulai</label>
          <input type="date" class="form-control @error('dateIni') is-invalid @enderror"
                 id="dateIni" name="dateIni" value="{{ old('dateIni') }}">
          @error('dateIni')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6 mb-3">
          <label for="dateFin" class="form-label">Tanggal Selesai</label>
          <input type="date" class="form-control @error('dateFin') is-invalid @enderror"
                 id="dateFin" name="dateFin" value="{{ old('dateFin') }}">
          @error('dateFin')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="mb-3">
        <label for="registerDateLimit" class="form-label">Batas Pendaftaran</label>
        <input type="date" class="form-control @error('registerDateLimit') is-invalid @enderror"
               id="registerDateLimit" name="registerDateLimit" value="{{ old('registerDateLimit') }}">
        @error('registerDateLimit')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <button type="submit" class="btn btn-primary mt-3">
        <i class="bi bi-arrow-right-circle-fill me-1"></i> Lanjut
      </button>
    </form>
  </div>
</div>

{{-- Auto-generate slug --}}
<script>
  document.querySelector('#name').addEventListener('change', function () {
    fetch('/dashboard/posts/checkSlug?title=' + this.value)
      .then(response => response.json())
      .then(data => document.querySelector('#slug').value = data.slug);
  });
</script>
@endsection
