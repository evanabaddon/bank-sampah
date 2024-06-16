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
                        {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                            <div class="col-md-2">
                                <input type="text" name="q" class="form-control pull-right" placeholder="Cari Nasabah" value="{{ request('q') }}">
                            </div>
                            <div class="col-md-1">
                                {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                            </div>
                            <div class="col-md-1">
                                {!! Form::selectRange('tahun', $tahunMin, $tahunMax, request('tahun'), ['class' => 'form-control', 'placeholder'=>'Pilih Tahun']) !!}
                            </div>
                            <div class="col-sm-2">
                                {!! Form::select('kategori_layanan_id', $kategoriLayanan, request('kategori_layanan_id'), ['class' => 'form-control', 'placeholder'=>'Pilih Kategori Layanan']) !!}
                            </div>
                            <div class="col-md-1">
                                <select name="status" class="form-control pull-left">
                                    <option value="">Status</option>
                                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Bayar</option>
                                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Terbayar</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                {!! Form::select('rt', $rt->mapWithKeys(function ($rt) {
                                    return [$rt => $rt];
                                }), request('rt'), ['class' => 'form-control', 'placeholder' => 'Pilih RT']) !!}
                            </div>
                            <div class="col-md-1">
                                {!! Form::select('rw', $rw->mapWithKeys(function ($rw) {
                                    return [$rw => $rw];
                                }), request('rw'), ['class' => 'form-control', 'placeholder' => 'Pilih RW']) !!}
                            </div>         
                            <div class="col-md-1">
                                <button type="submit" class="btn  btn-primary btn-block"><i class="fa fa-filter"></i>  Filter</button>
                            </div>
                        {!! Form::close() !!}
                            @if(Auth::user()->akses == 'admin')
                            <div class="col-md-2">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-block dropdown-toggle" type="button" id="more" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More <span class="caret"></span></button>
                                    <ul class="dropdown-menu" aria-labelledby="more">
                                        <li><a href="{{ route('buat-tagihan') }}"><i class="fa fa-plus"></i> Buat Tagihan</a></li>
                                        <li id="bayar-massal"><a href="#"><i class="fa fa-money"></i> Bayar Massal</a></li>
                                        <li><a href="{{ route('broadcast') }}"><i class="fa fa-whatsapp"></i> Broadcast Tagihan</a></li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="" id="select_all_ids" value="">
                                    </td>
                                    <th>No</th>
                                    <th>Invoice</th>
                                    <th>Nama Nasabah</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Kategori Layanan</th>
                                    <th>Total Tagihan</th>
                                    <th>Status</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Operator</th>
                                    <th style="width: 150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="tagihan_ids" class="checkbox_ids" id="" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{  'PPC/' . $item->id . '/' . $item->nasabah_id . '/' . date('my', strtotime($item->tanggal_tagihan)) }}</td>
                                        <td>{{ $item->nasabah->name }}</td>
                                        <td>{{ $item->tanggal_tagihan }}</td>
                                        <td>{{ $item->tanggal_jatuh_tempo }}</td>
                                        <td>{{ $item->nasabah->kategoriLayanan->name }}</td>
                                        <td>{{ $item->formatRupiah('jumlah_tagihan') }}</td>
                                        <td>
                                            @if ($item->status == 'belum')
                                                <span class="badge bg-red">Belum Bayar</span>
                                            @else
                                                <span class="badge bg-green">Terbayar</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->tanggal_bayar }}</td>
                                        <td>{{ $item->user ? $item->user->name : 'User Tidak Ditemukan' }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route' => [ 'nasabah.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin ingin menghapus data ini?")'
                                            ]) !!}
                                                @if ($item && $item->status === 'belum')
                                                    <a href="#" class="btn btn-block btn-success" data-toggle="modal" data-target="#confirmModal-{{ $item->id }}"><b>Bayar</b></a>
                                                @elseif ($item && $item->status === 'lunas')
                                                    <a href="{{ route('print.nota', ['tagihan_id' => $item->id]) }}" class="btn btn-primary" target="_blank" title="Cetak Nota">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                    <a href="{{ route('kirim.nota', ['tagihan_id' => $item->id]) }}" class="btn btn-success" title="Kirim Nota">
                                                        <i class="fa fa-paper-plane"></i>
                                                    </a>
                                                    @if(Auth::user()->akses == 'admin')
                                                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editStatusModal-{{ $item->id }}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                @endif
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    <!-- Modal Konfirmasi Pembayaran -->
                                    <div class="modal fade" id="confirmModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel-{{ $item->id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="confirmModalLabel-{{ $item->id }}">Konfirmasi Pembayaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin melakukan transaksi pembayaran untuk tagihan ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
                                                    @if ($item)
                                                    <a href="{{ route('update.and.print.nota', ['tagihan_id' => $item->id]) }}" class="btn btn-primary">Yakin</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Edit Status -->
                                    <div class="modal fade" id="editStatusModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editStatusModalLabel-{{ $item->id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="editStatusModalLabel-{{ $item->id }}">Edit Status Pembayaran</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open([
                                                        'route' => ['update.status', $item->id],
                                                        'method' => 'PUT'
                                                    ]) !!}
                                                    <div class="form-group">
                                                        {!! Form::label('status', 'Status Pembayaran') !!}
                                                        {!! Form::select('status', ['belum' => 'Belum Bayar'], null, ['class' => 'form-control', 'placeholder' => 'Pilih Status Pembayaran']) !!}
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="12">Data tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {!! $models->links() !!}
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    
    <!-- Modal Pembayaran Massal -->
    <div class="modal fade" id="modal-bayar-massal" tabindex="-1" role="dialog" aria-labelledby="modal-bayar-massal-label">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-bayar-massal-label">Pembayaran Massal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Nama Nasabah</th>
                                <th>Tanggal Tagihan</th>
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Kategori Layanan</th>
                                <th>Total Tagihan</th>
                            </tr>
                        </thead>
                        <tbody id="selected-invoices-list">
                            <!-- List of selected invoices will be displayed here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="submit-bayar-massal">Bayar Massal</button>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Modal Warning -->
    <div class="modal fade" id="no-data-warning-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Silahkan pilih satu atau lebih tagihan yang akan dibayar</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</section>
@section('scripts')
<script>
    $(function(e){
        $("#select_all_ids").click(function(e){
            if($(this).is(':checked',true))  
            {
                $(".checkbox_ids").prop('checked', true);  
            } else {  
                $(".checkbox_ids").prop('checked',false);  
            }  
        });

        // bayar masal modal
        $("#bayar-massal").click(function () {
            var selectedInvoices = [];
            $('input:checkbox[name=tagihan_ids]:checked').each(function () {
                var row = $(this).closest('tr');
                var invoiceData = {
                    invoiceNumber: row.find('td:eq(2)').text(),
                    customerName: row.find('td:eq(3)').text(),
                    invoiceDate: row.find('td:eq(4)').text(),
                    dueDate: row.find('td:eq(5)').text(),
                    serviceCategory: row.find('td:eq(6)').text(),
                    totalAmount: row.find('td:eq(7)').text(),
                };
                selectedInvoices.push(invoiceData);
            });

            // Check if any data is selected
            if (selectedInvoices.length > 0) {
                var modal = $("#modal-bayar-massal");
                var selectedInvoicesList = modal.find("#selected-invoices-list");
                selectedInvoicesList.empty();

                $.each(selectedInvoices, function (index, invoiceData) {
                    selectedInvoicesList.append(
                        '<tr>' +
                        '<td>' + invoiceData.invoiceNumber + '</td>' +
                        '<td>' + invoiceData.customerName + '</td>' +
                        '<td>' + invoiceData.invoiceDate + '</td>' +
                        '<td>' + invoiceData.dueDate + '</td>' +
                        '<td>' + invoiceData.serviceCategory + '</td>' +
                        '<td>' + invoiceData.totalAmount + '</td>' +
                        '</tr>'
                    );
                });

                modal.modal('show');
            } else {
                // Show a warning modal if no data is checked
                var warningModal = $("#no-data-warning-modal");
                warningModal.modal('show');
            }
        });

        $("#submit-bayar-massal").click(function () {
        // Collect selected tagihan IDs
        var selectedInvoices = [];
        $('input:checkbox[name=tagihan_ids]:checked').each(function () {
            var tagihanId = $(this).val();
            selectedInvoices.push(tagihanId);
        });

        if (selectedInvoices.length > 0) {
            // Send the selected tagihan IDs to the server for processing via Ajax
            $.ajax({
                type: "POST",
                url: "{{ route('bayar-massal') }}", // Ganti dengan URL yang sesuai
                data: {
                    '_token': '{{ csrf_token() }}',
                    'tagihan_ids': selectedInvoices
                },
                success: function (data) {
                    if (data.success) {
                        // Jika pembayaran berhasil, Anda dapat melakukan tindakan yang sesuai, misalnya menampilkan pesan sukses
                        alert("Pembayaran massal berhasil dilakukan.");
                    } else {
                        // Jika ada kesalahan atau pembayaran gagal, Anda dapat menangani kasus ini
                        alert("Pembayaran massal gagal.");
                    }
                    // Tutup modal bayar massal
                    $("#modal-bayar-massal").modal('hide');
                    // Refresh halaman atau lakukan tindakan lain yang sesuai
                    location.reload();
                },
                error: function (xhr, status, error) {
                    // Handle errors or failed requests
                    console.log(xhr.responseText);
                }
            });
        } else {
            // Show a warning modal if no data is checked
            var warningModal = $("#no-data-warning-modal");
            warningModal.modal('show');
        }
    });

    });

</script>
@endsection

@endsection
