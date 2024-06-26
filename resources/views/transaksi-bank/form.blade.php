@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Transaksi BSP
        <small>Tambah Transaksi BSP</small>
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
                        <label for="name" class="col-sm-2 control-label">Nama Nasabah</label>
                        <div class="col-sm-10">
                            {!! Form::select('id_nasabah', $nasabahs, $idNasabah, ['class'=>'form-control select2', 'data-width'=>'100%']) !!}
                            <span class="text-danger">{{ $errors->first('id_nasabah') }}</span> 
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
                                <th style="width: 50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="jenis_sampah[]" class="form-control" onchange="updateHarga(this)">
                                        <option value="">Pilih Jenis Sampah</option>
                                        @foreach($jenisSampahs as $jenisSampahId => $namaJenisSampah)
                                            <option value="{{ $jenisSampahId }}" data-harga="{{ $hargaSampah[$jenisSampahId] }}">{{ $namaJenisSampah }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <span class="harga"></span>
                                </td>
                                <td>
                                    <input type="text" name="berat[]" class="form-control berat" placeholder="Berat" oninput="updateAllSubtotals()">
                                </td>
                                <td>
                                    <span class="subtotal">0</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="addRow()">+</button>
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
    // Variabel untuk menyimpan harga sampah berdasarkan jenis sampah
    var hargaSampah = {!! json_encode($hargaSampah) !!};

    function addRow() {
        var jenisSampahTable = document.getElementById("jenisSampahTable");
        var newRow = jenisSampahTable.rows[1].cloneNode(true);
        
        // Reset nilai jenis sampah dan berat
        newRow.cells[0].getElementsByTagName('select')[0].value = '';
        newRow.cells[2].getElementsByTagName('input')[0].value = '';
        newRow.cells[3].getElementsByClassName('subtotal')[0].textContent = '0';
        
        // Menambahkan baris ke tabel
        jenisSampahTable.tBodies[0].appendChild(newRow);
        
        // Hubungkan event listener untuk perubahan subtotal pada elemen-elemen yang baru
        newRow.querySelector('input[name="berat[]"]').addEventListener('input', updateAllSubtotals);
        newRow.querySelector('select[name="jenis_sampah[]"]').addEventListener('change', updateHarga);
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

    // Fungsi untuk mengubah harga berdasarkan jenis sampah yang dipilih
    function updateHarga(selectElement) {
        var hargaSpan = selectElement.parentNode.parentNode.querySelector('.harga');
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var jenisSampahId = selectElement.value;

        // Mencari harga berdasarkan jenis sampah yang dipilih
        var harga = hargaSampah[jenisSampahId];

        // Menampilkan harga
        hargaSpan.textContent = harga;

        // Memperbarui subtotal saat mengubah jenis sampah
        updateAllSubtotals();
    }

    // Fungsi untuk menghitung subtotal di semua baris
    function updateAllSubtotals() {
        var beratInputs = document.querySelectorAll('input[name="berat[]"]');
        var subtotalSpans = document.querySelectorAll('.subtotal');
        var selectElements = document.querySelectorAll('select[name="jenis_sampah[]"]');
        
        beratInputs.forEach(function (beratInput, index) {
            var subtotalSpan = subtotalSpans[index];
            var berat = parseFloat(beratInput.value);
            var jenisSampahId = selectElements[index].value;
            var hargaSpan = selectElements[index].parentNode.parentNode.querySelector('.harga');
            var harga = parseFloat(hargaSpan.textContent);
            var subtotal = berat * harga;
            subtotalSpan.textContent = subtotal.toFixed(2);
        });
        updateTotal();
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
