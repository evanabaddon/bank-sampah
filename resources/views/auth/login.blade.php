@extends('layouts.core')

@section('content')
<style>
  .login-logo img {
      max-width: 150px; /* Sesuaikan dengan ukuran yang diinginkan */
      height: auto;
      margin-bottom: 10px; /* Berikan margin bawah agar terpisah dari teks di bawahnya */
  }
  .login-box {
      display: flex;
      justify-content: center; /* Memposisikan elemen secara horizontal di tengah */
      height: 80vh; /* Menggunakan tinggi layar penuh */
      flex-direction:column;
  }
  
  

</style>
<div class="login-box">
    <div class="login-logo">
      <a href=""><img src="{{ asset('images/'.settings()->get('app_logo')) }}" alt="SmartTrash Logo"></a>
      <p>{{ settings()->get('app_name') }}</b></p>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group has-feedback">
          <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
  
      <a href="{{ route('password.request') }}">I forgot my password</a><br>
  
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
@endsection
