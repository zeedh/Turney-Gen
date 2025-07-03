@extends('layouts.main')

@section('container')

<div class="row justify-content-center">
  <div class="col-lg-8">
    <a href="/register" class="btn btn-outline-success me-2">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Registrasi
    </a>
    <main class="form-registration w-100 m-auto shadow p-4 rounded bg-white mt-3">
      <h1 class="h3 mb-4 fw-semibold text-center text-success">Daftar Sebagai Panitia</h1>

      <form action="/register/panitia" method="post">
        @csrf

        <div class="row g-3">

          <div class="col-md-6">
            <div class="form-floating">
              <input type="email" name="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email" placeholder="Email" value="{{ old('email') }}" required>
              <label for="email">Alamat Email</label>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        
          <div class="col-md-6">
            <div class="form-floating position-relative">
              <input type="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password" placeholder="Password" required>
              <label for="password">Password</label>
              <i class="bi bi-eye-slash toggle-password"
                id="togglePassword"
                style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" name="name"
                class="form-control @error('name') is-invalid @enderror"
                id="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
              <label for="name">Nama Lengkap (Username)</label>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" name="firstname"
                class="form-control @error('firstname') is-invalid @enderror"
                id="firstname" placeholder="Nama Depan" value="{{ old('firstname') }}" required>
              <label for="firstname">Nama Depan</label>
              @error('firstname')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-floating">
              <input type="text" name="lastname"
                class="form-control @error('lastname') is-invalid @enderror"
                id="lastname" placeholder="Nama Belakang" value="{{ old('lastname') }}" required>
              <label for="lastname">Nama Belakang</label>
              @error('lastname')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-floating">
              <input type="date" name="birthDate"
                class="form-control @error('birthDate') is-invalid @enderror"
                id="birthDate" value="{{ old('birthDate') }}" required>
              <label for="birthDate">Tanggal Lahir</label>
              @error('birthDate')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          {{-- Gender --}}
          <div class="col-md-6">
            <div class="form-floating">
              <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                <option value="" disabled {{ old('gender') === null ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Laki-laki</option>
                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Perempuan</option>
              </select>
              <label for="gender">Jenis Kelamin</label>
              @error('gender')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

        </div> {{-- end row --}}

        {{-- Hidden is_panitia --}}
        <input type="hidden" name="is_panitia" value="1">

        <button class="btn btn-success w-100 py-2 mt-4" type="submit">Daftar</button>
      </form>

      <small class="d-block text-center mt-3">
        Sudah punya akun? <a href="/login">Login di sini</a>
      </small>
    </main>
  </div>
</div>

@push('scripts')
<script>
  const toggle = document.getElementById('togglePassword');
  const password = document.getElementById('password');
  toggle.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
  });
</script>
@endpush
@endsection
