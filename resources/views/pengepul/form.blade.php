@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Pengepul
        <small>Tambah Pengepul</small>
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
                        <label for="name" class="col-sm-2 control-label">Nama Pengepul</label>
                        <div class="col-sm-10">
                            {!! Form::text('name', $model->name ?  $model->name : '', ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('name') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-sm-2 control-label">Alamat Pengepul</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('alamat', $model->alamat, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('alamat') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="no_hp" class="col-sm-2 control-label">No HP Pengepul</label>
                        <div class="col-sm-10">
                            {!! Form::number('no_hp', $model->no_hp ?  $model->no_hp : '', ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('no_hp') }}</span> 
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


