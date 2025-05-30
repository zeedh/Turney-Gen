@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buat Championship {{ auth()->user()->name}}!!</h1>
  </div>
<div class="col-lg-8">
    <form method="post" action="/dashboard/champs" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="tournament" class="form-label">Turnamen</label>
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

        <button type="submit" class="btn btn-primary">Buat Championship</button>
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