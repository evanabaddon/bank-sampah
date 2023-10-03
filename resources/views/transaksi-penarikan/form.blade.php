@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Transaksi Penarikan
        <small>Tambah Transaksi Penarikan Saldo</small>
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
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'class'=>'form-horizontal']) !!}
                    
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama Nasabah</label>
                        <div class="col-sm-6">
                            {!! Form::select('id_nasabah', $nasabahs, $idNasabah, ['class'=>'form-control select2', 'data-width'=>'100%']) !!}
                            <span class="text-danger">{{ $errors->first('id_nasabah') }}</span> 
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label for="jumlah" class="col-sm-2 control-label">Jumlah</label>
                        <div class="col-sm-6">
                            {!! Form::text('jumlah', null, ['class'=>'form-control', 'data-rupiah'=>'true']) !!}
                            <span class="text-danger">{{ $errors->first('jumlah') }}</span> 
                        </div>                        
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>

@endsection
