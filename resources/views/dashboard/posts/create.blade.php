@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 mx-3 border-bottom">
    <h1 class="h2">My Posts {{ auth()->user()->name}}!!</h1>
  </div>
<div class="col-lg-8 mx-3">
    <form method="post" action="/dashboard/posts" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul Post</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title') }}">
            @error('title')
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
            <label for="tournament" class="form-label">Tournament</label>
            <select class="form-select" name="tournament_id">
                @foreach($tours as $tour)
                    @if (old('tournament_id') == $tour->id)
                        <option value="{{ $tour->id }}" selected>{{ $tour->name }}</option>
                    @else
                        <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                    @endif  
                @endforeach
            </select>
        </div>

        <div class="">
            <label for="image" class="form-label">Poster</label>
            
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <img class="img-preview img-fluid mt-3 col-sm-5" src="" alt="">
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Deskripsi Turnamen</label>
            @error ('body')
            <p class="text-danger">{{ $message }}</p>
                
            @enderror
            <input id="body" type="hidden" name="body" value="{{ old('body') }}">
            <trix-editor input="body"></trix-editor>
        </div>

        <button type="submit" class="btn btn-primary">Buat Post</button>
    </form>
</div>

<script>
    const title=document.querySelector('#title');
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