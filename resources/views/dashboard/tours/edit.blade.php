@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mx-4 border-bottom">
    <h1 class="h2">Edit Post</h1>
</div>

<div class="col-lg-8 mx-4">
    <form method="post" action="/dashboard/tours/{{ $tours->slug }}" enctype="multipart/form-data">
        @method('put')
        @csrf

        <!-- Input Fields -->
        <div class="mb-3">
            <label for="title" class="form-label">Judul Turnamen</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name', $tours->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug', $tours->slug) }}">
            @error('slug')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dateIni" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control @error('dateIni') is-invalid @enderror" id="dateIni" name="dateIni" value="{{ old('dateIni', $tours->dateIni) }}">
            @error('dateIni')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dateFin" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control @error('dateFin') is-invalid @enderror" id="dateFin" name="dateFin" value="{{ old('dateFin', $tours->dateFin) }}">
            @error('dateFin')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="registerDateLimit" class="form-label">Batas Pendaftaran</label>
            <input type="date" class="form-control @error('registerDateLimit') is-invalid @enderror" id="registerDateLimit" name="registerDateLimit" value="{{ old('registerDateLimit', $tours->registerDateLimit) }}">
            @error('registerDateLimit')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Button Row -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="/dashboard/tours" class="btn btn-outline-success">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </div>
    </form>
</div>


<script>
    const title=document.querySelector('#name');
    const slug=document.querySelector('#slug');
    
    title.addEventListener('change', function(){
        fetch('/dashboard/posts/checkSlug?title=' + title.value)
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