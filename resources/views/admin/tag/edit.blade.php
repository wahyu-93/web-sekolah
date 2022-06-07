@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ubah Tag</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-unlock"></i>
                        Ubah Tag
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.tag.update', $tag) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Tag</label>
                            <input type="text" name="name" id="name" value="{{ old('name') ?? $tag->name }}" placeholder="Masukkan Nama Tag"
                                class="form-control @error('name') is-invalid @enderror">
                            
                            @error('name')
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