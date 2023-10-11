@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Nasabah
        <small>Detail Nasabah</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <div style="text-align: center;">
                    {!! QrCode::size(250)->generate($model->kodenasabah) !!}
                </div>
                <h3 class="profile-username text-center">{{ $model->name }}</h3>
  
                <h4 class="text-muted text-center">{{ $model->nohp }}</h4>
  
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Terdaftar Pada</b> <a class="pull-right">{{ \Carbon\Carbon::parse($model->created_at)->translatedFormat('d F Y H:i:s') }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Saldo</b> <a class="pull-right">{{ $model->formatRupiah('saldo') }}</a>
                  </li>
                </ul>
                    {{-- tombol cetak kartu anggota --}}
                    <a href="{{ route('nasabah.cetakKartu', $model->id) }}" class="btn btn-success btn-block" target="_blank"><b>Cetak Kartu Anggota</b></a>
                    {{-- <button class="btn btn-warning btn-block" data-toggle="modal" data-target="#confirmGeneratePinModal"><b>Buat PIN Baru</b></button>
                    <a href="{{ route('nasabah.kirim-pin', $model->id) }}" class="btn btn-success btn-block" target="_blank"><b>Kirim PIN</b></a> --}}
                    {{-- tombol transaksi bank sampah dengan mengirim id_nasabah --}}
                    @if ($model->is_bsp)
                        <a href="{{ route('transaksi-bank.create', ['id_nasabah' => $model->id]) }}" class="btn btn-block btn-primary"><b>Transaksi BSP</b></a>
                    @else
                        <a href="{{ route('transaksi-bank.create', ['id_nasabah' => $model->id]) }}" class="btn btn-block btn-primary disabled"><b>Transaksi BSP</b></a>
                    @endif
                    {{-- tombol penarikan saldo jika saldo lebih dari 0 --}}
                    @if ($model->saldo > 0)
                        <a href="{{ route('transaksi-penarikan.create', ['id_nasabah' => $model->id]) }}" class="btn btn-block btn-danger"><b>Penarikan Saldo</b></a>
                    @else
                        <a href="{{ route('transaksi-penarikan.create', ['id_nasabah' => $model->id]) }}" class="btn btn-block btn-danger disabled"><b>Penarikan Saldo</b></a>
                    @endif
                    
                    
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- About Me Box -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">About Me</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>
                <p class="text-muted">{{ $model->alamat  . ' - RT : ' . $model->rt  . ' RW : ' .$model->rt}}</p>
                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> Layanan</strong>
                <p>
                    @if ($model->is_bsp)
                        <span class="badge bg-green">BSP (Bank Sampah) Aktif</span>
                    @else
                        <span class="badge bg-red">BSP (Bank Sampah) Tidak Aktif</span>
                    @endif
                    @if ($model->is_ppc)
                        <span class="badge bg-green">PPC (Pelayanan Sampah) Aktif</span>
                    @else
                        <span class="badge bg-red">PPC (Pelayanan Sampah) Tidak Aktif</span>
                    @endif
                </p>
                <hr>
                <strong><i class="fa fa-file-text-o margin-r-5"></i> Kategori Layanan</strong>
                <p>{{ $model->kategoriLayanan->name ?? '-' }}</p>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Tagihan Tahun {{ now()->year }}</h3>
                    {{-- <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            {!! Form::select('tahun_tagian', [], null, ['class'=>'form-control']) !!}
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div> --}}
                </div>
                
                <!-- /.box-header -->
                @php
                    $tagihans = $model->tagihans ?? collect();
                @endphp
                <div class="box-body table-responsive">
                    {{-- Tabel tagihan per bulan dengan status pembayaran --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Tanggal Tagihan</th>
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                                <th>Tanggal Bayar</th>
                                <th style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 12; $i++)
                                @php
                                    $monthName = date('F', mktime(0, 0, 0, $i, 1));
                                    $tagihan = $tagihans->first(function ($item) use ($i) {
                                            $itemDate = \Carbon\Carbon::parse($item->tanggal_tagihan);
                                            return $itemDate->format('Y') == now()->format('Y') && $itemDate->format('m') == $i;
                                        });
                                @endphp
                                <tr>
                                    <td>{{ $monthName }}</td>
                                    <td>{{ $tagihan ? \Carbon\Carbon::parse($model->tanggal_tagihan)->translatedFormat('d F Y') : '-' }}</td>
                                    <td>{{ $tagihan ? \Carbon\Carbon::parse($model->tanggal_jatuh_tempo)->translatedFormat('d F Y') : '-' }}</td>
                                    <td>{{ $tagihan ? $tagihan->formatRupiah('jumlah_tagihan') : '-' }}</td>
                                    <td>
                                        @if ($tagihan && $tagihan->status === 'belum')
                                            <span class="badge bg-red">Belum Dibayar</span>
                                        @elseif ($tagihan && $tagihan->status === 'lunas')
                                            <span class="badge bg-green">Lunas</span>
                                        @endif
                                    </td>
                                    <td>{{ $tagihan ? $tagihan->tanggal_bayar : '-' }}</td>
                                    <td>
                                        @if ($tagihan && $tagihan->status === 'belum')
                                            <a href="#" class="btn btn-block btn-success" data-toggle="modal" data-target="#confirmModal-{{ $i }}"><b>Bayar</b></a>
                                        @elseif ($tagihan && $tagihan->status === 'lunas')
                                            <a href="{{ route('print.nota', ['tagihan_id' => $tagihan->id]) }}" class="btn btn-primary" target="_blank">Cetak Nota</a>
                                            <a href="{{ route('kirim.nota', ['tagihan_id' => $tagihan->id]) }}" class="btn btn-success" target="_blank">Kirim Nota</a>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Modal Konfirmasi Pembayaran -->
                                <div class="modal fade" id="confirmModal-{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel-{{ $i }}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="confirmModalLabel-{{ $i }}">Konfirmasi Pembayaran</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin melakukan transaksi pembayaran untuk tagihan bulan {{ $monthName }}?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
                                                @if ($tagihan)
                                                <a href="{{ route('update.and.print.nota', ['tagihan_id' => $tagihan->id]) }}" class="btn btn-primary">Yakin</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </tbody>
                    </table> 
                </div>
                
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="confirmGeneratePinModal" tabindex="-1" role="dialog" aria-labelledby="confirmGeneratePinModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmGeneratePinModalLabel">Konfirmasi Generate PIN Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin membuat PIN baru untuk nasabah ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="#" class="btn btn-success" id="confirmGeneratePinBtn">Ya, Buat PIN Baru</a>
                </div>
            </div>
        </div>
    </div>
    
</section>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("confirmGeneratePinBtn").addEventListener("click", function () {
            // Mendapatkan ID nasabah dari tautan
            var nasabahId = "{{ $model->id }}";

            // Membuat URL rute generate PIN baru
            var url = "{{ route('nasabah.buat-pin', ':id') }}";
            url = url.replace(':id', nasabahId);

            // Redirect ke rute generate PIN baru
            window.location.href = url;
        });
    });
</script>
@endsection


