@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Championship</h1>
  </div>
<div class="col-lg-8">
    <form action="/dashboard/champs/{{ $champ->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- <div class="mb-3">
            <label for="tournament" class="form-label">Turnamen</label>
            <select class="form-select" name="tournament_id">
                @foreach($tours as $tour)
                    @if (old('tournament_id', $champ->tournament_id) == $tour->id)
                        <option value="{{ $tour->id }}" selected>{{ $tour->name }}</option>
                    @else
                        <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                    @endif  
                @endforeach
            </select>
        </div> -->

        <div class="mb-3">
            <label for="tournament" class="form-label">Turnamen</label>
            <p class="form-control-plaintext">{{ $tours->firstWhere('id', $champ->tournament_id)->name }}</p>
            <input type="hidden" name="tournament_id" value="{{ $champ->tournament_id }}">
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">category</label>
            <select class="form-select" name="category_id">
                @foreach($categories as $category)
                    @if (old('category_id', $champ->category_id) == $category->id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif  
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Championship</button>
    </form>
</div>
@endsection