@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Permissions</h1>
        </div>

        <div class="section-body">
            <div class="card-body">
                {{-- form pencrian --}}
                <form action="{{ route('admin.permission.index') }}" method="GET">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="q" id="q" class="form-control" placeholder="cari berdasarkan nama permission">
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
                                <th scope="col">Nama Permission</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($permissions as $no => $permission)
                                <tr>
                                    <td style="text-align: center;">
                                        {{ ++$no + ($permissions->currentPage()-1) * $permissions->perPage() }}
                                    </td>

                                    <td>
                                        {{ $permission->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="text-align: center">
                        {{ $permissions->links("vendor.pagination.bootstrap-4") }}
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>
@endsection