@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Transaksi Pengeluaran
        <small>Tambah Transaksi Pengeluaran</small>
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
                        <label for="deskripsi" class="col-sm-2 control-label">Deskripsi</label>
                        <div class="col-sm-6">
                           {!! Form::text('deskripsi', null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('deskripsi') }}</span> 
                        </div>                        
                    </div>

                    <div class="form-group">
                        <label for="jumlah" class="col-sm-2 control-label">Jumlah</label>
                        <div class="col-sm-6">
                           {!! Form::text('jumlah', null, ['class'=>'form-control', 'data-rupiah'=>'true']) !!}
                            <span class="text-danger">{{ $errors->first('jumlah') }}</span> 
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                        <div class="col-sm-6">
                           {!! Form::date('tanggal', null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal') }}</span> 
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
