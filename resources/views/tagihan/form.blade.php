@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Edit Tagihan
        <small>Edit detail tagihan</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form {{ $title }}</h3>
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
                <div class="box-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'class'=>'form-horizontal']) !!}
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama Nasabah</label>
                        <div class="col-sm-6">
                            {!! Form::text('name', $model->nasabah->name ?  $model->nasabah->name : '', ['class'=>'form-control','readonly']) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_tagihan" class="col-sm-2 control-label">Tgl Tagihan</label>
                        <div class="col-sm-6">
                            {!! Form::date('tanggal_tagihan', null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_tagihan') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_jatuh_tempo" class="col-sm-2 control-label">Tgl Jatuh Tempo</label>
                        <div class="col-sm-6">
                            {!! Form::date('tanggal_jatuh_tempo', null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal_jatuh_tempo') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tagihan" class="col-sm-2 control-label">Layanan</label>
                        <div class="col-sm-6">
                            {!! Form::text('jumlah_tagihan', $model->nasabah->kategoriLayanan->name ?  $model->nasabah->kategoriLayanan->name : '', ['class'=>'form-control','readonly']) !!}
                            <span class="text-danger">{{ $errors->first('jumlah_tagihan') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tagihan" class="col-sm-2 control-label">Jumlah Tagihan</label>
                        <div class="col-sm-6">
                            {!! Form::text('jumlah_tagihan', $model->jumlah_tagihan ?  $model->jumlah_tagihan : '', ['class'=>'form-control','readonly']) !!}
                            <span class="text-danger">{{ $errors->first('jumlah_tagihan') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-6">
                            {!! Form::select('status', ['belum', 'bayar'], null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('status') }}</span> 
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


