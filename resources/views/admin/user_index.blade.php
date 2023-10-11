@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User
            <small>Data User</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary">Tambah User</a>
                    </div>
                      <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center">No</th>
                                                <th rowspan="2" class="text-center">Nama</th>
                                                <th rowspan="2" class="text-center">No.HP</th>
                                                <th rowspan="2" class="text-center">Email</th>
                                                <th rowspan="2" class="text-center">Akses</th>
                                                <th rowspan="2" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($models as $item)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->nohp }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->akses }}</td>
                                    <td>
                                        {!! Form::open([
                                            'route' => [ $routePrefix . '.destroy', $item->id],
                                            'method' => 'DELETE',
                                            'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                        ]) !!}
                                         <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data tidak ada</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div> 
                        
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection