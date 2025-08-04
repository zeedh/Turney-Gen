@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
  <div class="col-lg-5">

    @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session()->has('loginError'))
      <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('loginError') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <main class="form-signin w-100 m-auto shadow p-4 rounded bg-white mt-3">
      <h1 class="h3 mb-4 fw-semibold text-center text-primary">Masuk ke Akun Anda</h1>

      <form action="/login" method="post">
        @csrf

        <div class="form-floating mb-3">
          <input type="email" name="email"
            class="form-control @error('email') is-invalid @enderror"
            id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
          <label for="email">Email</label>
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-floating mb-3 position-relative">
          <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
          <label for="password">Password</label>
          <i class="bi bi-eye-slash toggle-password" id="togglePassword"
             style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
        </div>

        <button class="btn btn-primary w-100 py-2 mb-2" type="submit">Login</button>
      </form>

      <small class="d-block text-center mt-3">
        <a href="{{ route('password.request') }}">Lupa Password?</a>
      </small>
      <small class="d-block text-center mt-3">
        Belum punya akun? <a href="/register">Daftar sekarang!</a>
      </small>
    </main>
  </div>
</div>

{{-- Toggle show/hide password --}}
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
