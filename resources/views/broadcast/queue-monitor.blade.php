@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Tagihan
        <small>Data Tagihan</small>
    </h1>
</section>
<section class="content">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border"> 
                    <div class="row">
                        
                    </div> 
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <p>Total Jobs in Queue: {{ $jobs }}</p>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Queue</th>
                                <th>Job</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <!-- Tambahkan kolom tambahan sesuai kebutuhan -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                            <tr>
                                <td>{{ $job->id }}</td>
                                <td>{{ $job->queue }}</td>
                                <td>{{ $job->name }}</td>
                                <td>{{ $job->status }}</td>
                                <td>{{ $job->created_at }}</td>
                                <!-- Tambahkan informasi tambahan di sini -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

</section>

@endsection

