@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Foto</h1>
        </div>

        <div class="section-body">
            @can('posts.create')
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="fas fa-image"></i>
                            Upload Foto
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.photo.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="image">Foto</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">

                                @error('image')
                                    <div class="invali-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="caption">Caption</label>
                                <input type="text" name="caption" id="caption" class="form-control @error('caption') is-invalid @enderror" placeholder="Masukkan Judul Foto">

                                @error('caption')
                                    <div class="invali-feedback" style="display: block">
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
            @endcan

            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-image"></i>
                        Foto
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center; width: 6%">No</th>
                                    <th scope="col" style="width: 10%">Foto</th>
                                    <th scope="col">Caption</th>
                                    <th scope="col" style="width : 15%; text-align : center">Aksi</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach($photos as $no => $photo)
                                    <tr>
                                        <th scope="col" style="text-align: center;">{{++$no + ($photos->currentPage()-1) * $photos->perPage() }}</th>
                                        <td>
                                            <img src="{{ $photo->image }}" alt="{{ $photo->caption }}" width="350px" class="mb-2 mt-2">
                                        </td>

                                        <td>{{ $photo->caption }}</td>
                                        
                                        <td class="text-center">
                                            <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $photo->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
    
                        <div style="text-align: center">
                            {{ $photos->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function Delete(id)
    {
        var id = id
        var token = $("meta[name='csrf-token']").attr('content')
        
        swal({
            title: 'Apakah Kamu Yakin?',
            text: 'Ingin Menghapus Data?',
            icon: 'warning',
            buttons:[
                'TIdak',
                'Ya'
            ],
            dangerMode: true
        }).then(function(isConfirm){
            if(isConfirm){
                // ajax hapus
                jQuery.ajax({
                    url: "/admin/photo/"+id,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function(response){
                        if(response.status=="success"){
                            swal({
                                title: 'Berhasil',
                                text: 'Data Berhasil Dihapus!',
                                icon: 'success',
                                timer: 1000,
                                buttons: false,
                            }).then(function(){
                                location.reload()
                            })
                        }
                        else {
                            swal({
                                title: 'Gagal',
                                text: 'Data Gagal Dihapus!',
                                icon: 'error',
                                timer: 1000,
                                buttons: false,
                            }).then(function(){
                                location.reload()
                            })
                        }
                    }
                })
            }
            else {
                return true
            }
        })
    }
 
</script>

@endsection