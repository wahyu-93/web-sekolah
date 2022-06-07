@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kategori</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-unlock"></i>
                        Tambah Kategori
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.category.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Category</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan Nama Category"
                                class="form-control @error('name') is-invalid @enderror">
                            
                            @error('name')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit">
                            <i class="fa fa-paper-plane"></i>
                            Simpan
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