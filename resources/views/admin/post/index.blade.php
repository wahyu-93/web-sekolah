@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Berita</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-book-open"></i>
                        Berita
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.post.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('posts.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.post.create') }}" class="btn btn-primary" style="padding-top: 10px;">
                                            <i class="fa fa-plus-circle"></i>
                                            Tambah
                                        </a>
                                    </div>
                                @endcan
                               
                                <input type="text" name="q" id="q" class="form-control" placeholder="cari berdasarkan judul berita">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center; width: 6%">No</th>
                                    <th scope="col">Judul Berita</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col" style="width : 15%; text-align : center">Aksi</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach($posts as $no => $post)
                                    <tr>
                                        <th scope="col" style="text-align: center;">{{++$no + ($posts->currentPage()-1) * $posts->perPage() }}</th>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        
                                        <td class="text-center">
                                            <a href="{{ route('admin.post.edit', [$post->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>

                                            <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $post->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
    
                        <div style="text-align: center">
                            {{ $posts->links("vendor.pagination.bootstrap-4") }}
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
                    url: "/admin/post/"+id,
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