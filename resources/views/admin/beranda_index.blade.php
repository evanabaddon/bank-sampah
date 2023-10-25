

{{-- if mobile detect use layouts.app-mobile --}}
{{-- @extends(
    (new Jenssegers\Agent\Agent())->isMobile() ? 
    'layouts.app-mobile' : 
    'layouts.app'
 ) --}}

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
                            <h4 style="font-weight: bold;">{{ $jumlahNasabah }}</h4>
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
                            <h4 style="font-weight: bold;">Rp {{ number_format($totalTagihanLunasBulanIni, 0, ',', '.') }}</h4>
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
                            <h4 style="font-weight: bold;">Rp {{ number_format($totalTagihanBulanIni, 0, ',', '.') }}</h4>
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
                            <h4 style="font-weight: bold;">Rp {{ number_format($totalTransaksiBankBulanIni, 0, ',', '.') }}</h4>
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
                        {{-- box-tool cetak chart --}}
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Print Chart" onclick="printChartPpc()">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                      </div>
                      <div class="box-body">
                        <p class="text-center">
                            <strong>Periode: Tahun {{ date('Y') }}</strong>
                        </p>
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
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Print Chart" onclick="printChartBsp()">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                      </div>
                      <div class="box-body">
                        <p class="text-center">
                            <strong>Periode: Tahun {{ date('Y') }}</strong>
                          </p>
                        <div class="chart">
                          <canvas id="chartBsp" style="height:250px"></canvas>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Rekap Laba / Rugi Tahun Ini</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Print Chart" onclick="printRekapChart()">
                            <i class="fa fa-print"></i>
                        </button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-12">
                          <p class="text-center">
                            <strong>Periode: Tahun {{ date('Y') }}</strong>
                          </p>
        
                          <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="rekapChart" style="height: 180px;"></canvas>
                          </div>
                          <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- ./box-body -->
                    <div class="box-footer">
                      <div class="row">
                        <div class="col-sm-4 col-xs-6">
                          <div class="description-block border-right">
                            @if($prosentasePemasukan > 0)
                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i>
                            @else
                                <span class="description-percentage text-red"><i class="fa fa-caret-down"></i>
                            @endif
                            {{ $prosentasePemasukan }} %</span>
                            <h5 class="description-header">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}</h5>
                            <span class="description-text">PEMASUKAN BULAN INI</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 col-xs-6">
                          <div class="description-block border-right">
                            @if($prosentasePengeluaran > 0)
                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i>
                            @else
                                <span class="description-percentage text-red"><i class="fa fa-caret-down"></i>
                            @endif
                            {{ $prosentasePengeluaran }} %</span>
                            <h5 class="description-header">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</h5>
                            <span class="description-text">PENGELUARAN BULAN INI</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 col-xs-6">
                          <div class="description-block">
                            @if($prosentaseLabaRugi > 0)
                                <span class="description-percentage text-green"><i class="fa fa-caret-up"></i>
                            @else
                                <span class="description-percentage text-red"><i class="fa fa-caret-down"></i>
                            @endif
                            {{ $prosentaseLabaRugi }} %</span>
                            <h5 class="description-header">Rp {{ number_format($labaRugiBulanIni, 0, ',', '.') }}</h5>
                            <span class="description-text">LABA / RUGI BULAN INI</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                      </div>
                      <!-- /.row -->
                    </div>
                    <!-- /.box-footer -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">10 Nasabah Terakhir</h3>
                            <div class="box-tools">
                                {{-- button "semua nasabah" --}}
                                <a href="{{ route('nasabah.index') }}" class="btn btn-primary btn-sm">Semua Nasabah</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
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
    var ctx = document.getElementById('chartPpc').getContext('2d');
    var pemasukanData = [{{  implode(",", $dataTagihanLunas); }} ];
    var pengeluaranData = [{{ implode(",", $dataTagihanBelumLunas);  }} ];

    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags','Sep','Okt','Nov','Des'],
            datasets: [
                {
                    label: 'Tagihan Lunas',
                    data: pemasukanData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true,
                },
                {
                    label: 'Tagihan Belum Lunas',
                    data: pengeluaranData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: true,
                },
            ],
        },
        options: {
            scales: {
                x: {
                    type: 'category',
                    title: {
                        display: true,
                        text: 'Tanggal'
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah'
                    }
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('chartBsp').getContext('2d');
    
    // Data pemasukan dan pengeluaran
    var dataTransaksiBSP = [{{ implode(",", $dataTransaksiBSP); }} ];

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags','Sep','Okt','Nov','Des'],
            datasets: [
                {
                    label: 'Transaksi BSP',
                    data: dataTransaksiBSP,
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true,
                },
            ],
        },
        options: {
            scales: {
                x: {
                    type: 'category',
                    title: {
                        display: true,
                        text: 'Tanggal'
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah'
                    }
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('rekapChart').getContext('2d');
    
    // Data pemasukan dan pengeluaran
    var pemasukanData = [{{ implode(",", $dataPemasukan);  }} ];
    var pengeluaranData = [{{ implode(",", $dataPengeluaran);  }} ];


    
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags','Sep','Okt','Nov','Des'],
            datasets: [
                {
                    label: 'Pemasukan',
                    data: pemasukanData,
                    backgroundColor: 'rgba(75, 192, 192, 1)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false,
                },
                {
                    label: 'Pengeluaran',
                    data: pengeluaranData,
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    fill: false,
                },
            ],
        },
        options: {
            scales: {
                x: {
                    type: 'category',
                    title: {
                        display: true,
                        text: 'Tanggal'
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah'
                    }
                }
            },
            legend: {
                display: true,
                position: 'bottom',
            }
        }
    });
</script>

<script>
    // Fungsi untuk mencetak chart PPC
    function printChartPpc() {
        var canvas = document.getElementById('chartPpc');
        var chartImage = canvas.toDataURL('image/png');

        // Buka gambar dalam jendela baru atau unduh sebagai file
        var newWindow = window.open();
        newWindow.document.write('<html><body><img src="' + chartImage + '"></body></html>');
        newWindow.document.close();
    }

    // Fungsi untuk mencetak chart BSP
    function printChartBsp() {
        var canvas = document.getElementById('chartBsp');
        var chartImage = canvas.toDataURL('image/png');

        // Buka gambar dalam jendela baru atau unduh sebagai file
        var newWindow = window.open();
        newWindow.document.write('<html><body><img src="' + chartImage + '"></body></html>');
        newWindow.document.close();
    }

    // Fungsi untuk mencetak chart Rekap
    function printRekapChart() {
        var canvas = document.getElementById('rekapChart');
        var chartImage = canvas.toDataURL('image/png');

        // Buka gambar dalam jendela baru atau unduh sebagai file
        var newWindow = window.open();
        newWindow.document.write('<html><body><img src="' + chartImage + '"></body></html>');
        newWindow.document.close();
    }

</script>

@endsection


