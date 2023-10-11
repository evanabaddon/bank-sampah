@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Pembayaran Masal Tagihan
        <small>Data Pembayaran Tagihan</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
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
                <div class="box-body table-responsive">
                    
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $models->links() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
@endsection