@extends('dashboard.layouts.main')

@section('container')
<style>
      @media (max-width: 767.98px) {
      .btn-sm {
        margin: 5px;
      }
    }

</style>
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 my-3 mx-3 col-lg-10">
  <a href="/dashboard/posts/create" class="btn btn-success">
    <i class="bi bi-plus-circle"></i> Buat User Baru
  </a>
</div> -->

@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show col-lg-8 mt-4" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card shadow-sm col-lg-10 mx-3 mt-4">
  <div class="card-body">
    <div class="mb-3">
      <input type="text" class="form-control" id="searchInput" placeholder="Cari User...">
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle" id="postTable">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Nama Depan</th>
            <th>Nama Belakang</th>
            <th>Gender</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($users as $user)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="fw-semibold">{{ $user->name }}</td>
            <td>{{ $user->email}}</td>
            <td>{{ $user->firstname}}</td>
            <td>{{ $user->lastname}}</td>
            <td>{{ $user->gender}}</td>
            <td>
              <a href="/dashboard/admin/{{ $user->id }}/edit" class="btn btn-sm btn-warning text-white">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
              <form action="/dashboard/admin/{{ $user->id }}" method="post" class="d-inline">
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
        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>
  </div>
</div>

<script>
  document.getElementById('searchInput').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#postTable tbody tr');

    rows.forEach(row => {
      const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
      row.style.display = name.includes(filter) ? '' : 'none';
    });
  });
</script>
@endsection
