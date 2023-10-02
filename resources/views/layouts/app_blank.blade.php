<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="PT. Agranirwasita Technology">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* CSS untuk mengubah ukuran font di tabel */
    .table-smaller-font {
        font-size: 12px; /* Ganti ukuran sesuai kebutuhan Anda */
    }

    /* Gaya cetak */
    @media print {
        /* CSS untuk header tabel gelap saat mencetak */
        .table-dark thead {
            background-color: #343a40; /* Warna latar belakang header gelap */
            color: #fff; /* Warna teks pada header gelap */
        }
    }

    /* CSS untuk header tabel gelap */
    .table-dark thead {
        background-color: #343a40; /* Warna latar belakang header gelap */
        color: #fff; /* Warna teks pada header gelap */
    }



    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

  </style>
  <style>
    @media print {
        .box {
            overflow: visible !important;
            page-break-before: auto;
        }
        
        .table-responsive {
            overflow: visible !important;
        }
        
        .print-button {
            display: none;
        }
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">


    


      @include('flash::message')
      @yield('content')

    
    <!-- /.content -->

  <!-- /.content-wrapper -->




<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 3 -->
<script src="{{ asset('adminlte') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('adminlte') }}/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('adminlte') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="{{ asset('adminlte') }}/bower_components/raphael/raphael.min.js"></script>
<script src="{{ asset('adminlte') }}/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('adminlte') }}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{ asset('adminlte') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ asset('adminlte') }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('adminlte') }}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('adminlte') }}/bower_components/moment/min/moment.min.js"></script>
<script src="{{ asset('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{ asset('adminlte') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('adminlte') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="{{ asset('adminlte') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ asset('adminlte') }}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte') }}/dist/js/adminlte.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/cdn.jsdelivr.net_npm_select2@4.1.0-rc.0_dist_css_select2.min.css') }}">
<script src="{{ asset('js/cdn.jsdelivr.net_npm_select2@4.1.0-rc.0_dist_js_select2.min.js') }}"></script>

@yield('scripts')
<script>
  // Fungsi untuk menghilangkan tanda desimal dan memberi format mata uang Rupiah pada input
  function formatRupiah(angka) {
      var number_string = angka.toString().replace(/[^,\d]/g, ''),
          split = number_string.split(','),
          sisa = split[0].length % 3,
          rupiah = split[0].substr(0, sisa),
          ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
      }

      return rupiah;
  }

  $(document).ready(function() {
      
      // Fungsi untuk mengaktifkan format mata uang Rupiah saat mengetik
      $("input[data-rupiah='true']").keyup(function(event) {
          $(this).val(formatRupiah($(this).val()));
      });

      // Fungsi untuk menghilangkan tanda desimal saat form disubmit
      $("form").submit(function() {
          $("input[data-rupiah='true']").each(function() {
              var inputValue = $(this).val();
              $(this).val(inputValue.replace(/[^\d]/g, ''));
          });
      });
  });
</script>
<script>
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
{{-- chart --}}
</body>
</html>