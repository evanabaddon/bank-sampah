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
                        <a href="{{ route('nasabah.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                        <a href="#" data-toggle="modal" data-target="#importModal" class="btn btn-success" id="importButton"><i class="fa fa-upload"></i> Import</a>
                        <a href="{{ route('nasabah.export') }}" class="btn btn-success"><i class="fa fa-download"></i> Export</a>
                    @endif
                    <div class="box-tools">
                        {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="q" class="form-control pull-right" placeholder="Cari Nasabah">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
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
                                    <th>Layanan BSP</th>
                                    <th>Layanan PPC</th>
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
                                                @if(Auth::user()->akses == 'admin')
                                                    <a href="{{ route('nasabah.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
                                                @endif
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
                <!-- Modal Import Nasabah -->
                <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="importModalLabel">Import Nasabah</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <input type="file" id="fileInput" class="form-control-file" name="file">
                                        </div>
                                        <div class="col-sm-4">
                                            <button type="submit" class="btn btn-primary btn-block" id="uploadButton">Upload</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="mt-2">
                                    <p>Anda juga dapat mengunduh file contoh <a href="https://unitppc.bumdespringgondani.com/file/SampleImportNasabah.xlsx">di sini</a>.</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection
