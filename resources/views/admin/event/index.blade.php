@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Agenda</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>
                        <i class="fas fa-bell"></i>
                        Agenda
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.event.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('events.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.event.create') }}" class="btn btn-primary" style="padding-top: 10px;">
                                            <i class="fa fa-plus-circle"></i>
                                            Tambah
                                        </a>
                                    </div>
                                @endcan
                               
                                <input type="text" name="q" id="q" class="form-control" placeholder="cari berdasarkan event">
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
                                    <th scope="col">Judul Agenda</th>
                                    <th scope="col">Lokasi</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col" style="width : 15%; text-align : center">Aksi</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach($events as $no => $event)
                                    <tr>
                                        <th scope="col" style="text-align: center;">{{++$no + ($events->currentPage()-1) * $events->perPage() }}</th>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->location }}</td>
                                        <td>{{ $event->date }}</td>
                                        
                                        <td class="text-center">
                                            <a href="{{ route('admin.event.edit', [$event->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>

                                            <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $event->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
    
                        <div style="text-align: center">
                            {{ $events->links("vendor.pagination.bootstrap-4") }}
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
                    url: "/admin/event/"+id,
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