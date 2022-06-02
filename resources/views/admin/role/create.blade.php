@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Role</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-unlock"></i>
                        Tambah Role
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.role.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Role</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Masukkan Nama Role"
                                class="form-control @error('name') is-invalid @enderror">
                            
                            @error('name')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label style="font-weight: bold">Permissions</label>
                            @foreach ($permissions as $permission)
                                <input type="checkbox" name="permissions[]" id="check-{{ $permission->id }}" value="{{ $permission->name }}">
                                <label for="check-{{ $permission->id }}" class="form-check-label">
                                    {{ $permission->name }}
                                </label>
                            @endforeach
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit">
                            <i class="fa fa-paper-plane"></i>
                            Simpan
                        </button>
                        
                        <button class="btn btn-warning btn-rese" type="reset">
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