@extends('dashboard.layouts.main')

@section('container')
<style>
      @media (max-width: 767.98px) {
      .btn-sm {
        margin: 5px;
      }
    }

</style>


@if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show col-lg-8" role="alert">
    <i class="bi bi-check-circle-fill me-1"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card shadow-sm col-lg-10 my-3">
  <div class="card-body">
    <div class="mb-3">
      <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan turnamen atau kategori...">
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle" id="champTable">
        <thead class="table-light">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Turnamen</th>
            <th scope="col">Kategori</th>
            <th scope="col" class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($champs as $champ)
            <tr data-tournament="{{ strtolower($champ->tournament->name) }}" data-category="{{ strtolower($champ->category->name) }}">
              <td>{{ $loop->iteration }}</td>
              <td class="fw-semibold">{{ $champ->tournament->name }}</td>
              <td>{{ $champ->category->name }}</td>
              <td class="text-center">
                <a href="/dashboard/champs/{{ $champ->id }}/edit" class="btn btn-sm btn-primary me-1">
                  <i class="bi bi-diagram-3"></i> Kelola
                </a>
                <form action="/dashboard/champs/{{ $champ->id }}" method="post" class="d-inline">
                  @method('delete')
                  @csrf
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus bagan ini?')">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      @if ($champs->isEmpty())
        <p class="text-center text-muted mt-3">Belum ada bagan kejuaraan.</p>
      @endif
    </div>
  </div>
</div>

{{-- Live Search Script --}}
<script>
  const searchInput = document.getElementById('searchInput');
  const rows = document.querySelectorAll('#champTable tbody tr');

  searchInput.addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    rows.forEach(row => {
      const tournament = row.dataset.tournament;
      const category = row.dataset.category;
      row.style.display = (tournament.includes(keyword) || category.includes(keyword)) ? '' : 'none';
    });
  });
</script>
@endsection
