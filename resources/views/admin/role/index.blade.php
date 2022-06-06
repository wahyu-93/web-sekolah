@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Roles</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-unlock"></i>
                        Roles
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.role.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('roles.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.role.create') }}" class="btn btn-primary" style="padding-top: 10px;">
                                            <i class="fa fa-plus-circle"></i>
                                            Tambah
                                        </a>
                                    </div>
                                @endcan
                               


                                <input type="text" name="q" id="q" class="form-control" placeholder="cari berdasarkan role">
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
                                    <th scope="col" style="width : 15% ">Nama Role</th>
                                    <th scope="col">Permissions</th>
                                    <th scope="col" style="width : 15%; text-align : center">Aksi</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach($roles as $no => $role)
                                    <tr>
                                        <th scope="col" style="text-align: center;">{{++$no + ($roles->currentPage()-1) * $roles->perPage() }}</th>
                                        
                                        <td>{{ $role->name }}</td>
                                        
                                        <td>
                                            @foreach ($role->getPermissionNames() as $permission)
                                                <button class="btn btn-sm btn-success mb-1 mt-1 mr-1">{{ $permission }}</button>
                                            @endforeach
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.role.edit', [$role->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>

                                            <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $role->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
    
                        <div style="text-align: center">
                            {{ $roles->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // ajax delete
    function Delete(id)
    {
        var id = id
        var token = $("meta[name='csrf-token']").attr("content");
        console.log(token)
        swal({
            title: "Apakah Kamu Yakin?",
            text: "Ingin Mengahapus Data ini ?",
            icon: "warning",
            buttons: [
                'Tidak',
                'Ya'
            ],
            dangerMode: true,
        }).then(function(isConfirm){
            if(isConfirm){
                // ajax delete
                jQuery.ajax({
                    url: "/admin/role/"+id,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: 'DELETE',
                    success: function(response){
                        if(response.status == "success"){
                            swal({
                                title: 'Berhasil',
                                text: 'Data Berhasil Dihapus',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButoon: false,
                                buttons: false,
                            }).then(function(){
                                location.reload()
                            });
                        }
                        else{
                            swal({
                                title: 'Gagal',
                                text: 'Data Gagal Dihapus',
                                icon: 'error',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButoon: false,
                                buttons: false,
                            }).then(function(){
                                location.reload()
                            });
                        }
                    }
                });
            }
            else{
                return true
            }
        })
    }
</script>
@endsection