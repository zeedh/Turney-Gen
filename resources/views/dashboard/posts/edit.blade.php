@extends('dashboard.layouts.main')

@section('container')
<div class="col-lg-8">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Edit Post</h4>
            <a href="/dashboard/posts" class="btn btn-light btn-sm">← Kembali</a>
        </div>
        <div class="card-body">
            <form method="post" action="/dashboard/posts/{{ $post->slug }}" enctype="multipart/form-data">
                @method('put')
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">📝 Judul Post</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title', $post->title ) }}">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tournament" class="form-label">🏆 Turnamen</label>
                    <input type="text" class="form-control" id="tournament" value="{{ $post->tournament->name }}" disabled>
                    <input type="hidden" name="tournament_id" value="{{ $post->tournament_id }}">
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">🔗 Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" required value="{{ old('slug', $post->slug) }}">
                    @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">🖼️ Gambar</label>
                    <input type="hidden" name="oldImage" value="{{ $post->image }}">
                    @if($post->image)
                        <img src="{{ asset('storage/'.$post->image) }}" class="img-preview img-fluid mb-3 mt-2 col-sm-6 rounded shadow-sm">
                    @else
                        <img class="img-preview img-fluid mb-3 mt-2 col-sm-6 rounded shadow-sm">
                    @endif
                    <input class="form-control @error('image') is-invalid @enderror mt-2" type="file" id="image" name="image" onchange="previewImage()">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">📰 Konten Post</label>
                    @error('body')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
                    <trix-editor input="body"></trix-editor>
                </div>

                <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Update Post</button>
            </form>
        </div>
    </div>
</div>

<script>
    const title = document.querySelector('#title');
    const slug = document.querySelector('#slug');

    title.addEventListener('change', function(){
        fetch('/dashboard/posts/checkSlug?title=' + title.value)
        .then(response => response.json())
        .then(data => slug.value = data.slug)
    });

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
