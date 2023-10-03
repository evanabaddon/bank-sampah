@extends('layouts.app')

@section('content')
<section class="content-header">
   
</section>
<section class="content">
   
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


