@extends('dashboard.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Daftar Turnamen {{ auth()->user()->name}}!!</h1>
  </div>
  @if(session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
      {{ session('success') }}
    </div>
  @endif
  <div class="table-responsive small col-lg-8">
      <a href="/dashboard/tours/create" class="btn btn-primary mb-3">Buat Turnamen baru</a>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tours as $tour)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $tour->name }}</td>
              <td>
                <a href="/dashboard/tours/{{ $tour->slug }}" class="badge bg-info">lihat</a>
                <a href="/dashboard/tours/{{ $tour->slug }}/edit" class="badge bg-warning">edit</a>
                <form action="/dashboard/tours/{{ $tour->slug }}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('Yakin?')">HAPUS</button>
                </form>
              </td>
            </tr>
            @endforeach
            <tr>
          </tbody>
        </table>
      </div>
@endsection