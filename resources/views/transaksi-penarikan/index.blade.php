@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Transaksi Penarikan
        <small>Data Transaksi Penarikan Saldo</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <a href="{{ route('transaksi-penarikan.create') }}" class="btn btn-primary">Tambah Penarikan</a>
                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 200px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Nasabah</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Transaksi</th>
                                    <th>Operator</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nasabah->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->formatRupiah('jumlah') }}</td>
                                        <td>{{ $item->user ? $item->user->name : 'User Tidak Ditemukan' }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route' => [ 'nasabah.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                            ]) !!}
                                            <div class="btn-group">
                                                <a href="{{ route('transaksi-penarikan.show', ['transaksi_penarikan' => $item->id]) }}" class="btn btn-primary">Detail</a>
                                                {{-- spasi --}}
                                                &nbsp;
                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#confirmModalDelete-{{ $item->id }}"><b>Hapus</b></a>
                                            </div>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    <!-- Modal Konfirmasi Hapus -->
                                    <div class="modal fade" id="confirmModalDelete-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalDeleteLabel-{{ $item->id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="confirmModalDeleteLabel-{{ $item->id }}">Konfirmasi Hapus Transaksi</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus transaksi ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('transaksi-bank.destroy', ['transaksi_bank' => $item->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
