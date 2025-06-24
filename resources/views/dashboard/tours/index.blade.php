@extends('dashboard.layouts.main')

@section('container')
<style>
      @media (max-width: 767.98px) {
      .btn-sm {
        margin: 5px;
      }
    }

</style>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mx-3 col-lg-10">

  <a href="/dashboard/tours/create" class="btn btn-success">
    <i class="bi bi-plus-circle me-1"></i> Buat Turnamen Baru
  </a>
</div>

@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show col-lg-8" role="alert">
    <i class="bi bi-check-circle-fill me-1"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="col-lg-10 mx-3">
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="mb-3">
        <input type="text" class="form-control" id="searchInput" placeholder="Cari turnamen...">
      </div>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="tournamentTable">
          <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Judul Turnamen</th>
              <th scope="col">Dibuat</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($tours as $tour)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-semibold">{{ $tour->name }}</td>
                <td>{{ $tour->created_at->format('d M Y') }}</td>
                <td>
                  <!-- <a href="/dashboard/tours/{{ $tour->slug }}" class="btn btn-sm btn-info text-white me-1">
                    <i class="bi bi-eye"></i> Lihat
                  </a> -->
                  <a href="/dashboard/tours/{{ $tour->slug }}/edit" class="btn btn-sm btn-primary text-white me-1">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <form action="/dashboard/tours/{{ $tour->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus turnamen ini?')">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="text-center text-muted">Belum ada turnamen.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Live Search Script --}}
<script>
  document.getElementById('searchInput').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tournamentTable tbody tr');

    rows.forEach(row => {
      const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
      row.style.display = name.includes(filter) ? '' : 'none';
    });
  });
</script>
@endsection
