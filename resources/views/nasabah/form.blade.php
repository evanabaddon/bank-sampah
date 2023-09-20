@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Nasabah
        <small>Tambah Nasabah</small>
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
                            <label for="name" class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                {!! Form::text('name', $model->name ?  $model->name : '', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('name') }}</span> 
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
                            <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-10">
                                {!! Form::textarea('alamat', $model->alamat ?  $model->alamat : '', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('alamat') }}</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rt" class="col-sm-2 control-label">RT</label>
                            <div class="col-sm-10">
                                {!! Form::text('rt', $model->rt ?  $model->rt : '', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('rt') }}</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rw" class="col-sm-2 control-label">RW</label>
                            <div class="col-sm-10">
                                {!! Form::text('rw', $model->rw ?  $model->rw : '', ['class'=>'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('rw') }}</span> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-sm-2 control-label">Jenis Layanan</label>
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('is_ppc', 1, $model->is_ppc == 1, ['name' => 'is_ppc']) !!}
                                        PPC (Pelayanan Sampah)
                                    </label>
                                </div>
                                <span class="text-danger">{{ $errors->first('is_ppc') }}</span>
                                <div class="checkbox">
                                    <label>
                                        {!! Form::checkbox('is_bsp', 1, $model->is_bsp == 1, ['name' => 'is_bsp']) !!}
                                        BSP (Bank Sampah)
                                    </label>
                                </div>
                                <span class="text-danger">{{ $errors->first('is_bsp') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kategori_layanan_id" class="col-sm-2 control-label">Kategori Layanan</label>
                            <div class="col-sm-10">
                                {!! Form::select('kategori_layanan_id', $kategoriLayanans->pluck('name', 'id'), null, ['class'=>'form-control', 'id' => 'kategori_layanan']) !!}
                                <span class="text-danger">{{ $errors->first('kategori_layanan_id') }}</span> 
                            </div>
                        </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                </div>
            </div>
            <!-- /.box -->
            {!! Form::close() !!}
        </div>
    </div>
    {{-- modal peringatan wajib pilih minimal 1 kategori layanan --}}
    <div class="modal fade" id="validation-modal" tabindex="-1" role="dialog" aria-labelledby="validation-modal-title">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="validation-modal">Peringatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Minimal harus memilih salah satu jenis layanan
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary modal-close-button" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isPpcCheckbox = document.querySelector('[name="is_ppc"]');
        const kategoriLayananField = document.getElementById('kategori_layanan');
        const form = document.querySelector('form');

        // Fungsi untuk mengatur status dropdown select kategori layanan
        function setKategoriLayananStatus() {
            if (isPpcCheckbox.checked) {
                kategoriLayananField.removeAttribute('disabled');
            } else {
                kategoriLayananField.setAttribute('disabled', 'disabled');
                kategoriLayananField.value = null; // Set nilai pilihan menjadi null
            }
        }

        // Panggil fungsi setiap kali checkbox is_ppc berubah
        isPpcCheckbox.addEventListener('change', setKategoriLayananStatus);

        // Panggil fungsi saat halaman dimuat untuk mengatur status awal
        setKategoriLayananStatus();

        // Panggil fungsi validasi saat pengiriman formulir
        form.addEventListener('submit', function (event) {
            if (!isPpcCheckbox.checked) {
                kategoriLayananField.value = null; // Set nilai pilihan menjadi null jika tidak ada layanan PPC terpilih
            }

            if (!isPpcCheckbox.checked) {
                kategoriLayananField.value = null; // Set nilai pilihan menjadi null jika tidak ada layanan PPC terpilih
            } else if (!kategoriLayananField.value) {
                event.preventDefault();
                alert('Harap pilih kategori layanan.');
            }
        });
    });
</script>

@endsection


