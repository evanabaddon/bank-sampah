@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Dashboard
        <small>Sistem Informasi SmartTrash</small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $jumlahNasabah }}</h3>
                    <p>Total Nasabah</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-stalker"></i>
                </div>
                <a href="{{ route('nasabah.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Rp {{ number_format($totalTagihanLunasBulanIni, 0, ',', '.') }}</h3>
                    <p>PPC Lunas Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('tagihan.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Rp {{ number_format($totalTagihanBulanIni, 0, ',', '.') }}</h3>
                    <p>PPC Belum Lunas Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            <a href="{{ route('tagihan.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>Rp {{ number_format($totalTransaksiBankBulanIni, 0, ',', '.') }}</h3>
                    <p>Total Transaksi BSP Bulan Ini</p>
                </div>
                    <div class="icon">
                    <i class="ion ion-clipboard"></i>
                </div>
                <a href="{{ route('transaksi-bank.index') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Grafik Transaksi PPC Dalam 1 Tahun</h3>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="chartPpc" style="height:250px"></canvas>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Grafik Transaksi BSP Dalam 1 Tahun</h3>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="chartBsp" style="height:250px"></canvas>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">10 Nasabah Terakhir</h3>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>RT</th>
                                <th>RW</th>
                                <th>No. HP</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nasabahTerakhir as $key => $nasabah)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $nasabah->name }}</td>
                                    <td>{{ $nasabah->alamat }}</td>
                                    <td>{{ $nasabah->rt }}</td>
                                    <td>{{ $nasabah->rw }}</td>
                                    <td>{{ $nasabah->nohp }}</td>
                                    <td>{{ $nasabah->formatRupiah('saldo') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<script>
    // Data transaksi per bulan dari model Tagihan
    var dataTransaksi = @json($dataTransaksi);

    // Ekstrak label bulan dan jumlah transaksi dari data
    var labels = dataTransaksi.map(function(item) {
        return item.bulan_tahun;
    });
    var totalTagihanLunas = dataTransaksi.map(function(item) {
        return item.total_tagihan_lunas;
    });
    var totalTagihanBelumLunas = dataTransaksi.map(function(item) {
        return item.total_tagihan_belum_lunas;
    });

    var data = {
        labels: labels,
        datasets: [
            {
                label: "Total Tagihan Lunas",
                backgroundColor: "rgba(0, 123, 255, 0.6)",
                borderColor: "rgba(0, 123, 255, 1)",
                borderWidth: 1,
                data: totalTagihanLunas
            },
            {
                label: "Total Tagihan Belum Lunas",
                backgroundColor: "rgba(255, 0, 0, 0.6)",
                borderColor: "rgba(255, 0, 0, 1)",
                borderWidth: 1,
                data: totalTagihanBelumLunas
            }
        ]
    };

    var areaChartCanvas = document.getElementById("chartPpc").getContext("2d");

    var areaChart = new Chart(areaChartCanvas, {
        type: 'line',
        data: data,
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: "#f3f3f3",
                        zeroLineColor: "#f3f3f3"
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });

</script>
<script>
    // Data transaksi BSP per bulan
    var dataTransaksiBSP = @json($dataTransaksiBSP);

    // Ekstrak label bulan dan total transaksi BSP dari data
    var labelsBSP = dataTransaksiBSP.map(function(item) {
        return item.bulan_tahun;
    });
    var totalTransaksiBSP = dataTransaksiBSP.map(function(item) {
        return item.total_transaksi_bsp;
    });

    var dataBSP = {
        labels: labelsBSP,
        datasets: [
            {
                label: "Total Transaksi BSP",
                backgroundColor: "rgba(0, 123, 255, 0.6)",
                borderColor: "rgba(0, 123, 255, 1)",
                borderWidth: 1,
                data: totalTransaksiBSP
            }
        ]
    };

    var chartBSPCanvas = document.getElementById("chartBsp").getContext("2d");

    var chartBSP = new Chart(chartBSPCanvas, {
        type: 'bar',
        data: dataBSP,
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: "#f3f3f3",
                        zeroLineColor: "#f3f3f3"
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });

</script>
@endsection


