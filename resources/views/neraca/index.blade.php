@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Neraca Keuangan
        <small>Data Neraca Keuangan</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="row">
                        <form action="{{ route('neraca-keuangan.index') }}" method="GET">
                            <div class="col-md-2 col-sm-2"  style="margin-top: 10px;">
                                {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                            </div>
                            <div class="col-md-2" style="margin-top: 10px;">
                                {!! Form::selectRange('tahun', date('Y'), date('Y') + 1, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!}
                            </div>
                            <div class="col-md-2" style="margin-top: 10px;">
                                <button type="submit" class="btn btn-block btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    
                    @if ($bulanSelected && $tahunSelected)
                        @php
                        $namaBulan = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                        @endphp
                    
                        @if (isset($namaBulan[$bulanSelected]))
                            <h4>Neraca Keuangan Bulan: {{ $namaBulan[$bulanSelected] }} Tahun: {{ $tahunSelected }}</h4>
                        @else
                            <h4>Neraca Keuangan Bulan: {{ $bulanSelected }} Tahun: {{ $tahunSelected }}</h4>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Debet (Pemasukan)</th>
                                    <th>Kredit (Pengeluaran)</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $rowNumber = 1;
                                @endphp
                    
                                @foreach ($pemasukan as $transaksi)
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>
                                        @if ($transaksi->sumber == 'Tagihan')
                                        {{ $transaksi->tanggal_tagihan }}
                                        @elseif ($transaksi->sumber == 'Penjualan')
                                        {{ $transaksi->tanggal }}
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaksi->sumber == 'Tagihan')
                                        Tagihan {{ optional($transaksi->nasabah)->name }} Bulan {{ date('F Y', strtotime($transaksi->tanggal_bayar)) }}
                                        @elseif ($transaksi->sumber == 'Penjualan')
                                        Penjualan Sampah
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaksi->sumber == 'Tagihan')
                                        Rp {{ number_format($transaksi->jumlah_tagihan, 0, ',', '.') }},-
                                        @elseif ($transaksi->sumber == 'Penjualan')
                                        Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }},-
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach
                    
                                @foreach ($pengeluaran as $transaksi)
                                <tr>
                                    <td>{{ $rowNumber++ }}</td>
                                    <td>{{ $transaksi->tanggal }}</td>
                                    <td>{{ $transaksi->deskripsi }}</td>
                                    <td></td>
                                    <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }},-</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>Rp {{ number_format($totalDebet, 0, ',', '.')  }},-</th>
                                    <th>Rp {{ number_format($totalKredit, 0, ',', '.') }},-</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="5">Laba / Rugi</th>
                                    <th >Rp {{ number_format($saldo, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <h4 style="text-align: center;">Silahkan Pilih Bulan dan Tahun</h4>
                    @endif
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                            $bulanSelected = request('bulan');
                            $tahunSelected = request('tahun');
                            @endphp

                            <a href="{{ $bulanSelected && $tahunSelected ? route('neraca-keuangan.pdf', ['bulan' => $bulanSelected, 'tahun' => $tahunSelected]) : '#' }}" class="btn btn-danger{{ $bulanSelected && $tahunSelected ? '' : ' disabled' }}"{{ $bulanSelected && $tahunSelected ? '' : ' disabled="disabled"' }}>
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Cetak PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
