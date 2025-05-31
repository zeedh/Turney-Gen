@extends('dashboard.champs.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        Edit bagan turnamen "{{ $champ->tournament->name }}" 
        untuk kategori "{{ $champ->category->name }}"!!
    </h1>

  </div>

@endsection



