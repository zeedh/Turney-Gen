@extends('layouts.main')

@section('container')
<div class="row justify-content-center">
  <div class="col-lg-5">
    <main class="form-registration">
      <h1 class="h3 mb-3 fw-normal">Registration Form</h1>
      <form action="/register" method="post">
        @csrf

      <div class="form-floating">
          <input type="text" name="name" class="form-control rounded-top @error('name') is-invalid @enderror" id="name" placeholder="Name" required value="{{ old('name') }}">
          <label for="name">Name</label>
          @error('name')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

      <div class="form-floating">
          <input type="text" name="firstname" class="form-control rounded-top @error('firstname') is-invalid @enderror" id="firstname" placeholder="firstname" required value="{{ old('firstname') }}">
          <label for="firstname">Firstname</label>
          @error('firstname')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>
        

        <div class="form-floating">
            <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" id="lastname" placeholder="lastname" required value="{{ old('lastname') }}">
          <label for="lastname">Lastname</label>
          @error('lastname')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-floating">
          <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
          <label for="email">Email address</label>
          @error('email')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <div class="form-floating">
          <input type="password" name="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
          <label for="password">Password</label>
          @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
          @enderror
        </div>

        <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Register</button>
      </form>
      <small class="d-block text-center mt-3">Already registered? <a href="/login">Login!</a></small>
    </main>
  </div>
</div>


@endsection