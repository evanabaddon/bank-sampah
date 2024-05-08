@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Pengaturan
        <small>Pengaturan Applikasi</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Pengaturan Aplikasi</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(['route' => 'setting.store', 'method' => 'POST','class'=>'form-horizontal', 'files' => true]) !!}
                    <div class="form-group">
                        <label for="app_name" class="col-sm-2 control-label">Nama Aplikasi</label>
                        <div class="col-sm-10">
                            {!! Form::text('app_name', settings()->get('app_name'), ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('app_name') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="app_email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                           {!! Form::email('app_email', settings()->get('app_email'), ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('app_email') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="app_address" class="col-sm-2 control-label">Alamat</label>
                        <div class="col-sm-10">
                            {!! Form::textarea('app_address', settings()->get('app_address'), ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('app_address') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="app_phone" class="col-sm-2 control-label">Telepon</label>
                        <div class="col-sm-10">
                            {!! Form::number('app_phone', settings()->get('app_phone'), ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('app_phone') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="app_website" class="col-sm-2 control-label">Website</label>
                        <div class="col-sm-10">
                            {!! Form::text('app_website', settings()->get('app_website'), ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('app_website') }}</span> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="app_logo" class="col-sm-2 control-label">Logo Aplikasi</label>
                        <div class="col-sm-10">
                            {!! Form::file('app_logo', ['class'=>'form-control', 'enctype' => 'multipart/form-data', 'accept' => 'image/*']) !!}
                            <span class="text-danger">{{ $errors->first('app_logo') }}</span> 
                            @if(settings()->get('app_logo'))
                                <img src="{{ asset('images/'.settings()->get('app_logo')) }}" alt="" class="img-responsive" width="100">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="app_stempel" class="col-sm-2 control-label">Stempel Aplikasi</label>
                        <div class="col-sm-10">
                            {!! Form::file('app_stempel', ['class'=>'form-control', 'enctype' => 'multipart/form-data', 'accept' => 'image/*']) !!}
                            <span class="text-danger">{{ $errors->first('app_stempel') }}</span> 
                            @if(settings()->get('app_stempel'))
                                <img src="{{ asset('images/'.settings()->get('app_stempel')) }}" alt="" class="img-responsive" width="100">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="wa_api" class="col-sm-2 control-label">API Whatsapp Server</label>
                        <div class="col-sm-10">
                            {!! Form::text('wa_api', settings()->get('wa_api'), ['class'=>'form-control']) !!}
                            <small id="wa_api_helper" class="form-text text-muted">Masukkan API untuk WhatsApp Server. Kosongkan jika tidak menggunakan layanan Notifikasi Whatsapp</small>
                            <span class="text-danger">{{ $errors->first('wa_api') }}</span> 
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! Form::submit('UPDATE', ['class'=> 'btn btn-primary pull-right']) !!}
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection


