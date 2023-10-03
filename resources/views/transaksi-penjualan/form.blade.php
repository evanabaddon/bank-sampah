@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Transaksi Penjualan
        <small>Tambah Transaksi Penjualan Sampah</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form {{ $title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::model($model, ['route' => $route, 'method' => $method, 'class'=>'form-horizontal']) !!}
                    <div class="form-group">
                        <label for="tanggal" class="col-sm-2 control-label">Tanggal Transaksi</label>
                        <div class="col-sm-6">
                            {!! Form::date('tanggal', null, ['class'=>'form-control']) !!}
                            <span class="text-danger">{{ $errors->first('tanggal') }}</span> 
                        </div>                        
                    </div>
                    <!-- Tabel untuk detail jenis sampah -->
                    <table class="table table-bordered" id="jenisSampahTable">
                        <thead>
                            <tr>
                                <th>Jenis Sampah</th>
                                <th>Harga / Kg</th>
                                <th>Berat (kg)</th>
                                <th>Subtotal</th>
                                <th style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="jenis_sampah[]" class="form-control">
                                        <option value="">Pilih Jenis Sampah</option>
                                        @foreach($jenisSampahs as $jenisSampahId => $namaJenisSampah)
                                            <option value="{{ $jenisSampahId }}">{{ $namaJenisSampah }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    {!! Form::text('harga[]', null, ['class'=>'form-control harga', 'data-rupiah' => 'true', 'oninput' => 'updateSubtotal(this)']) !!}
                                </td>
                                <td>
                                    <input type="text" name="berat[]" class="form-control berat" placeholder="Berat" oninput="updateSubtotal(this)">
                                </td>
                                <td>
                                    <span class="subtotal">0.00</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="addRow()">+</button>
                                    <!-- Tambahkan tombol "Kurang" -->
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                                <td><span id="total">0.00</span></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

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

<script>
    // Fungsi untuk menghitung subtotal
    function updateSubtotal(input) {
        var row = input.closest('tr');
        var harga = row.querySelector('.harga').value;
        var berat = row.querySelector('.berat').value;
        var subtotal = row.querySelector('.subtotal');

        var subTotalValue = parseFloat(harga.replace(/\D/g, '')) * parseFloat(berat);
        subtotal.textContent = subTotalValue.toFixed(2);

        updateTotal();
    }

    // Fungsi untuk menambahkan baris
    function addRow() {
        var jenisSampahTable = document.getElementById("jenisSampahTable");
        var newRow = jenisSampahTable.rows[1].cloneNode(true);

        // Reset nilai jenis sampah, harga, dan berat
        var selectElement = newRow.cells[0].getElementsByTagName('select')[0];
        selectElement.value = '';

        var inputHarga = newRow.cells[1].querySelector('.harga');
        inputHarga.value = '';

        var inputBerat = newRow.cells[2].querySelector('.berat');
        inputBerat.value = '';

        var subtotalSpan = newRow.cells[3].querySelector('.subtotal');
        subtotalSpan.textContent = '0.00';

        // Menambahkan tombol "Kurang"
        var deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger';
        deleteButton.textContent = '-';
        deleteButton.addEventListener('click', function() {
            deleteRow(this); // Panggil fungsi deleteRow saat tombol "Kurang" diklik
        });
        newRow.cells[4].innerHTML = ''; // Kosongkan sel pada kolom Action
        newRow.cells[4].appendChild(deleteButton); // Tambahkan tombol "Kurang" ke dalam sel

        // Menambahkan baris ke tabel
        jenisSampahTable.tBodies[0].appendChild(newRow);

        // Aktifkan tombol hapus jika lebih dari satu baris
        updateDeleteButtons();
    }

    // Fungsi untuk menghapus baris
    function deleteRow(button) {
        var jenisSampahTable = document.getElementById("jenisSampahTable");
        var row = button.parentNode.parentNode;
        jenisSampahTable.tBodies[0].removeChild(row);
        updateTotal();
        // Perbarui tombol hapus
        updateDeleteButtons();
    }

    // Fungsi untuk menghitung total
    function updateTotal() {
        var rows = document.querySelectorAll('#jenisSampahTable tbody tr');
        var total = 0;

        rows.forEach(function(row) {
            var subtotal = row.querySelector('.subtotal').textContent;
            total += parseFloat(subtotal);
        });

        // Tampilkan total di bawah tabel
        document.getElementById("total").textContent = total.toFixed(2);
    }

    // Fungsi untuk mengaktifkan/tidak tombol hapus
    function updateDeleteButtons() {
        var jenisSampahTable = document.getElementById("jenisSampahTable");
        var rows = jenisSampahTable.tBodies[0].getElementsByTagName('tr');

        // Sembunyikan tombol hapus jika hanya ada satu baris
        if (rows.length === 1) {
            rows[0].querySelector('.btn-danger').style.display = 'none';
        } else {
            for (var i = 0; i < rows.length; i++) {
                rows[i].querySelector('.btn-danger').style.display = 'block';
            }
        }
    }
</script>

@endsection
