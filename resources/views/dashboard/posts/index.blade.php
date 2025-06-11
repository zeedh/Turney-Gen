@extends('dashboard.layouts.main')

@section('container')
<style>
      @media (max-width: 767.98px) {
      .btn-sm {
        margin: 5px;
      }
    }

</style>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mx-3 border-bottom">
  <h2 class="h3">Daftar Postingan {{ auth()->user()->name }}</h2>
  <a href="/dashboard/posts/create" class="btn btn-success">
    <i class="bi bi-plus-circle"></i> Buat Post Baru
  </a>
</div>

@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show col-lg-8" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card shadow-sm col-lg-10">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Judul</th>
            <th>Turnamen</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($posts as $post)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="fw-semibold">{{ $post->title }}</td>
            <td>{{ $post->tournament->name ?? '—' }}</td>
            <td>
              <a href="/dashboard/posts/{{ $post->slug }}" class="btn btn-sm btn-primary text-white">
                <i class="bi bi-eye"></i> Lihat
              </a>
              <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-warning text-white">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
              <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                  <i class="bi bi-trash3"></i> 
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center text-muted">Belum ada postingan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
