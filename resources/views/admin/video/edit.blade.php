@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ubah Video</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-video"></i>
                        Ubah Video
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.video.update', $video) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Judul Video</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" placeholder="Masukkan Judul Video"
                                class="form-control @error('title') is-invalid @enderror">
                            
                            @error('title')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="embed">Embed Video</label>
                            <input type="text" name="embed" id="embed" value="{{ old('embed', $video->embed) }}" placeholder="Masukkan Embed Youtube"
                                class="form-control @error('embed') is-invalid @enderror">
                            
                            @error('embed')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
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
@endsection