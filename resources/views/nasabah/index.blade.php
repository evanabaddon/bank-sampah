@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Nasabah
        <small>Data Nasabah</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    @if(Auth::user()->akses == 'admin')
                        <a href="{{ route('nasabah.create') }}" class="btn btn-primary">Tambah Nasabah</a>
                    @endif
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Cari Nasabah">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Nasabah</th>
                                    <th>Nama</th>
                                    <th class="d-none d-sm-table-cell">No.HP</th>
                                    <th class="d-none d-sm-table-cell">Alamat</th>
                                    <th>RT</th>
                                    <th>RW</th>
                                    <th>Layanan BSP (Bank Sampah)</th>
                                    <th>Layanan PPC (Pelayanan Sampah)</th>
                                    <th>Kategori Layanan</th>
                                    <th>Saldo</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kodenasabah }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->nohp }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->rt }}</td>
                                        <td>{{ $item->rw }}</td>
                                        <td>
                                            @if ($item->is_bsp)
                                                <span class="badge bg-green">Aktif</span>
                                            @else
                                                <span class="badge bg-red">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->is_ppc)
                                                <span class="badge bg-green">Aktif</span>
                                            @else
                                                <span class="badge bg-red">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->kategoriLayanan->name ?? '-' }}</td>
                                        <td>{{ $item->formatRupiah('saldo') }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route' => [ 'nasabah.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                            ]) !!}
                                            <div class="btn-group">
                                                <a href="{{ route('nasabah.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-info"></i> Detail</a>
                                                <a href="{{ route('nasabah.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="9">Data tidak ada</td>
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
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection
