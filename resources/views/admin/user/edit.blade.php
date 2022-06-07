@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Ubah User</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-unlock"></i>
                        Ubah User
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama User</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama User"
                                class="form-control @error('name') is-invalid @enderror">
                            
                            @error('name')
                                <div class="invalid feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan Email"
                                class="form-control @error('email') is-invalid  @enderror()">

                            @error('email')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Masukkan Password"
                                        class="form-control @error('password') is-invalid @enderror">

                                    @error('password')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password_confirmation" placeholder="Masukkan Konfirmasi Password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="font-weight: bold">Role</label>
                            @foreach ($roles as $role)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="role[]" id="check-{{ $role->id }}" value="{{ $role->name }}" class="form-check-input"
                                        {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                    <label for="check-{{ $role->id }}" class="form-check-label">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit">
                            <i class="fa fa-paper-plane"></i>
                            Update
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