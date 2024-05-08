@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Pengepul
        <small>Data Pengepul</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <a href="{{ route('pengepul.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                    <div class="box-tools">
                        {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                        <div class="input-group input-group-sm hidden-xs" style="width: 200px;">
                            <input type="text" name="q" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($models as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td>
                                        {!! Form::open([
                                            'route' => [ 'pengepul.destroy', $item->id],
                                            'method' => 'DELETE',
                                            'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                        ]) !!}
                                        <a href="{{ route('pengepul.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data tidak ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $models->links() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection


