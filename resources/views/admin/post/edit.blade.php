@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ubah Berita</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-open-book"></i>
                        Ubah Berita
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.post.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="image">Gambar</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">Judul Berita</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" placeholder="Masukkan Judul Berita"
                                class="form-control @error('title') is-invalid @enderror">
                            
                            @error('title')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori</option>

                                @foreach($categories as $category)
                                    @if($post->category_id == $category->id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>  
                                    @endif
                                @endforeach
                            </select>

                            @error('category_id')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Konten</label>
                            <textarea name="content" id="content" rows="20" class="form-control content @error('content') is-invalid @enderror" placeholder="Masukkan Konten/Isi Berita">{!! old('content', $post->content) !!}</textarea>
                            
                            @error('content')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">Tag</label>
                            <select name="tags[]" id="tags" class="form-control" multiple="multiple">
                                <option value="">-- Pilih Tag</option>

                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $post->tags()->pluck('id')->toArray()) ? 'selected' : '' }} >{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>                        

                        <button class="btn btn-primary mr-1 btn-submit" type="submit">
                            <i class="fa fa-paper-plane"></i>
                            Update
                        </button>
                        
                        <button class="btn btn-warning btn-reset" type="reset">
                            <i class="fa fa-redo"></i>
                            Reset
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
<script>
    var editor_config = {
        selector: "textarea.content",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
    };

    tinymce.init(editor_config);
</script>
@endsection