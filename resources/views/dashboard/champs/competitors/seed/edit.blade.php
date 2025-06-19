@extends('dashboard.champs.layouts.main')

@section('container')
<div class="card shadow-sm p-3 mt-4">
    <h4>Update Seed untuk Turnamen "{{ $champ->tournament->name }}"</h4>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('competitors.seed.save', $champ->id) }}">
        @csrf

        @foreach($competitors as $comp)
            <div class="mb-3">
                <label>{{ $comp->user->name }}</label>
                <input type="number" name="seeds[{{ $comp->id }}]" value="{{ $comp->seed }}" class="form-control" style="max-width: 120px;">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">
            Simpan Seed
        </button>
    </form>
</div>
@endsection
