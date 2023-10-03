@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Dashboard
        <small>Sistem Informasi Ciptakarya</small>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Horizontal Form</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                
                <form role="form" action="{{ route('user.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                {!! Form::text('name', $model->name ?  $model->name : '', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('name') }}</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                {!! Form::text('email', $model->email ?  $model->email : '', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('email') }}</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nohp" class="col-sm-2 control-label">No HP</label>
                            <div class="col-sm-10">
                                {!! Form::text('nohp', $model->nohp ?  $model->nohp : '', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('nohp') }}</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nohp" class="col-sm-2 control-label">Hak Akses</label>
                            <div class="col-sm-10">
                                {!! Form::select('akses', [
                                    'admin' => 'Admin',
                                    'operator' => 'Operator',
                                ], null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nohp" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                {!! Form::password('password', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('password') }}</span> 
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                    </div>
                  <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
    
@endsection
