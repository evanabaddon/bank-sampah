@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Laporan
        <small>Halaman Laporan</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form {{ $title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <h4>Laporan Tagihan Sampah</h4>
                    <div class="row">
                        {!! Form::open(['route' => 'laporan.tagihan', 'method' => 'GET']) !!}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kategori_layanan_id" class="control-label">Layanan</label>
                                {!! Form::select('kategori_layanan_id', $kategoriLayanans->pluck('name', 'id'), null, ['class'=>'form-control', 'id' => 'kategori_layanan', 'placeholder' => 'Pilih Layanan']) !!}    
                                <span class="text-danger">{{ $errors->first('kategori_layanan_id') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status" class="control-label">Status</label>
                                    {!! Form::select('status', [
                                        ''=> 'Pilih Status',
                                        'lunas' => 'Lunas',
                                        'belum' => 'Belum Lunas'
                                        ], null, ['class'=>'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bulan" class="control-label">Bulan</label>
                                {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                                <span class="text-danger">{{ $errors->first('bulan') }}</span> 
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tahun" class="control-label" >Tahun</label>
                                {{-- {!! Form::selectRange($name, $min, $max), $selected, [$options !!} --}}
                                {{-- {!! Form::selectRange('tahun', date('Y'), date('Y') + 1, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!} --}}
                                {!! Form::selectRange('tahun', $tahunTagihanMin, $tahunTagihanMax, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!}
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-primary">Tampil</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <hr>
                    <h4>Laporan Bank Sampah</h4>
                    <div class="row">
                        {!! Form::open(['route' => 'laporan.transaksi-bank', 'method' => 'GET']) !!}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama" class="control-label">Nama Nasabah</label>
                                {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder' => 'Nama Nasabah']) !!}    
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="jenis_sampah_id" class="control-label">Jenis Sampah</label>
                                {!! Form::select('jenis_sampah_id', $jenisSampahs->pluck('name', 'id'), null, ['class'=>'form-control', 'id' => 'jenis_sampah', 'placeholder' => 'Pilih Jenis Sampah']) !!}  
                                    <span class="text-danger">{{ $errors->first('jenis_sampah_id') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bulan" class="control-label">Bulan</label>
                                {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                                <span class="text-danger">{{ $errors->first('bulan') }}</span> 
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tahun" class="control-label" >Tahun</label>
                                {!! Form::selectRange('tahun', $tahunBankMin, $tahunBankMax, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!}
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-primary">Tampil</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <hr>
                    <h4>Laporan Penarikan Saldo</h4>
                    <div class="row">
                        {!! Form::open(['route' => 'laporan.transaksi-penarikan', 'method' => 'GET']) !!}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nama" class="control-label">Nama Nasabah</label>
                                {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder' => 'Nama Nasabah']) !!}    
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bulan" class="control-label">Bulan</label>
                                {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                                <span class="text-danger">{{ $errors->first('bulan') }}</span> 
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tahun" class="control-label" >Tahun</label>
                                {!! Form::selectRange('tahun', $tahunBankMin, $tahunBankMax, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!}
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-primary">Tampil</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <hr>
                    <h4>Laporan Penjualan Sampah</h4>
                    <div class="row">
                        {!! Form::open(['route' => 'laporan.transaksi-penjualan', 'method' => 'GET']) !!}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="jenis_sampah_id" class="control-label">Jenis Sampah</label>
                                {!! Form::select('jenis_sampah_id', $jenisSampahs->pluck('name', 'id'), null, ['class'=>'form-control', 'id' => 'jenis_sampah', 'placeholder' => 'Pilih Jenis Sampah']) !!}  
                                    <span class="text-danger">{{ $errors->first('jenis_sampah_id') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="bulan" class="control-label">Bulan</label>
                                {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                                <span class="text-danger">{{ $errors->first('bulan') }}</span> 
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="tahun" class="control-label" >Tahun</label>
                                {!! Form::selectRange('tahun', $tahunBankMin, $tahunBankMax, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!}
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-primary">Tampil</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection


