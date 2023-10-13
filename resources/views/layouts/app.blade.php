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

    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

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

    /* Gaya default untuk appBottomMenu */
    .appBottomMenu {
        display: none; /* Sembunyikan pada tampilan desktop */
        position: sticky;
        bottom: 0;
        background-color: #fff; 
    }

    /* Gunakan media query untuk menampilkan appBottomMenu hanya pada tampilan ponsel */
    @media (max-width: 767px) {
        .appBottomMenu {
            display: block; /* Tampilkan pada tampilan ponsel */
            /* Tambahan gaya lainnya sesuai kebutuhan Anda */
        }
    }
    
  </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>T</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Smart</b>Trash</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png" class="img-circle" alt="User Image">
                <p>
                  {{ Auth::user()->name }}<br>
                  {{ Auth::user()->email }}
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/1200px-User_icon_2.svg.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">UTAMA</li>
        @if(Auth::user()->akses == 'operator')
          <li class="{{ \Route::is('operator.beranda') ? 'active' : '' }}"><a href="{{ route('operator.beranda') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class="header">MASTER DATA</li>
          <li class="{{ \Route::is('nasabah.*') ? 'active' : '' }}"><a href="{{ route('nasabah.index') }}"><i class="fa fa-group"></i> <span>Nasabah</span></a></li>
          <li class="header">TRANSAKSI</li>
          <li class="{{ \Route::is('tagihan.*') ? 'active' : '' }}"><a href="{{ route('tagihan.index') }}"><i class="fa fa-file-text-o"></i> <span>Transaksi PPC</span></a></li>
          <li class="{{ \Route::is('transaksi-bank.*') ? 'active' : '' }}"><a href="{{ route('transaksi-bank.index') }}"><i class="fa fa-university"></i> <span>Transaksi BSP</span></a></li>
        @elseif(Auth::user()->akses == 'admin')
          <li class="{{ \Route::is('admin.beranda') ? 'active' : '' }}"><a href="{{ route('admin.beranda') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class="header">MASTER DATA</li>
          <li class="{{ \Route::is('kategori-layanan.*') ? 'active' : '' }}"><a href="{{ route('kategori-layanan.index') }}"><i class="fa fa-exchange"></i> <span>Kategori Layanan</span></a></li>
          <li class="{{ \Route::is('jenis-sampah.*') ? 'active' : '' }}"><a href="{{ route('jenis-sampah.index') }}"><i class="fa fa-trash-o"></i> <span>Jenis Sampah</span></a></li>
          <li class="{{ \Route::is('pengepul.*') ? 'active' : '' }}"><a href="{{ route('pengepul.index') }}"><i class="fa fa-archive"></i> <span>Pengepul</span></a></li>
          <li class="{{ \Route::is('nasabah.*') ? 'active' : '' }}"><a href="{{ route('nasabah.index') }}"><i class="fa fa-group"></i> <span>Nasabah</span></a></li>
          <li class="header">TRANSAKSI</li>
          <li class="{{ \Route::is('tagihan.*') ? 'active' : '' }}"><a href="{{ route('tagihan.index') }}"><i class="fa fa-file-text-o"></i> <span>Transaksi PPC</span></a></li>
          <li class="{{ \Route::is('transaksi-bank.*') ? 'active' : '' }}"><a href="{{ route('transaksi-bank.index') }}"><i class="fa fa-university"></i> <span>Transaksi BSP</span></a></li>
          <li class="{{ \Route::is('transaksi-pengeluaran.*') ? 'active' : '' }}"><a href="{{ route('transaksi-pengeluaran.index') }}"><i class="fa fa-money" aria-hidden="true"></i><span>Transaksi Pengeluaran</span></a></li>
          <li class="{{ \Route::is('transaksi-penarikan.*') ? 'active' : '' }}"><a href="{{ route('transaksi-penarikan.index') }}"><i class="fa fa-credit-card" aria-hidden="true"></i><span>Transaksi Penarikan</span></a></li>
          <li class="{{ \Route::is('transaksi-penjualan.*') ? 'active' : '' }}"><a href="{{ route('transaksi-penjualan.index') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Transaksi Penjualan</span></a></li>
          <li class="header">LAPORAN</li>
          <li class="{{ \Route::is('laporan.*') ? 'active' : '' }}"><a href="{{ route('laporan.index') }}"><i class="fa fa-files-o"></i> <span>Cetak Laporan</span></a></li>
          <li class="{{ \Route::is('neraca-keuangan.*') ? 'active' : '' }}"><a href="{{ route('neraca-keuangan.index') }}"><i class="fa fa-file-text"></i> <span>Neraca Keuangan</span></a></li>
          <li class="header">USER</li>
          <li class="{{ \Route::is('user.*') ? 'active' : '' }}"><a href="{{ route('user.index') }}"><i class="fa fa-user"></i> <span>Data User</span></a></li>
          <li class="header">PENGATURAN</li>
          <li class="{{ \Route::is('setting.*') ? 'active' : '' }}"><a href="{{ route('setting.create') }}"><i class="fa fa-cogs"></i> <span>Pengaturan</span></a></li>
        @endif
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      
      @yield('content')

    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Made With ❤️
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2023 <a href="https://www.instagram.com/evanhelga/">Digitaloka</a>.</strong> All rights reserved.
  </footer>
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>

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