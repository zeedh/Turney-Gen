@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Turnamen anda, {{ auth()->user()->name}}!!</h1>
  </div>
<div class="col-lg-8">
    <form method="post" action="/dashboard/tours" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul Turnamen</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug') }}">
            @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">category</label>
            <select class="form-select" name="category_id">
                @foreach($categories as $category)
                    @if (old('category_id') == $category->id)
                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endif  
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="dateIni" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control @error('dateIni') is-invalid @enderror" id="dateIni" name="dateIni" value="{{ old('dateIni') }}">
            @error('dateIni')
        <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dateFin" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control @error('dateFin') is-invalid @enderror" id="dateFin" name="dateFin" value="{{ old('dateFin') }}">
            @error('dateFin')
            <div class="invalid-feedback pb-4">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="registerDateLimit" class="form-label">Batas Pendfataran</label>
            <input type="date" class="form-control @error('registerDateLimit') is-invalid @enderror" id="registerDateLimit" name="registerDateLimit" value="{{ old('registerDateLimit') }}">
            @error('registerDateLimit')
            <div class="invalid-feedback pb-4">
                {{ $message }}
            </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-4">Lanjut</button>
    </form>
</div>

<script>
    const title=document.querySelector('#name');
    const slug=document.querySelector('#slug');
    
    title.addEventListener('change', function(){
        fetch('/dashboard/tours/checkSlug?title=' + title.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    });

    document.eventListener('trix-file-aacept', function(e){
        e.preventDefault();
    })


    function previewImage(){

        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>


@endsection