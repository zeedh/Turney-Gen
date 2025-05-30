@extends('dashboard.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Championship {{ auth()->user()->name}}!!</h1>
  </div>
  @if(session()->has('success'))
    <div class="alert alert-success col-lg-8" role="alert">
      {{ session('success') }}
    </div>
  @endif
  <div class="table-responsive small col-lg-8">
      <a href="/dashboard/champs/create" class="btn btn-primary mb-3">Buat Championship baru</a>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Turnamen</th>
              <th scope="col">Kategori</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($champs as $champ)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $champ->tournament->name }}</td>
              <td>{{ $champ->category->name }}</td>
              <td>
                <a href="/dashboard/champs/{{ $champ->id }}" class="badge bg-info">lihat</a>
                <a href="/dashboard/champs/{{ $champ->id }}/edit" class="badge bg-warning">edit</a>
                <form action="/dashboard/champs/{{ $champ->id }}" method="post" class="d-inline">
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