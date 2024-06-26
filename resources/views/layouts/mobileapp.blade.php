<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ settings()->get('app_name') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title -->
    <title>{{ settings()->get('app_name') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('affan') }}/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="{{ asset('affan') }}/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('affan') }}/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('affan') }}/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('affan') }}/img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('affan') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('affan') }}/css/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('affan') }}/css/tiny-slider.css">
    <link rel="stylesheet" href="{{ asset('affan') }}/css/baguetteBox.min.css">
    <link rel="stylesheet" href="{{ asset('affan') }}/css/rangeslider.css">
    <link rel="stylesheet" href="{{ asset('affan') }}/css/vanilla-dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('affan') }}/css/apexcharts.css">
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="{{ asset('affan') }}/style.css">
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('affan') }}/manifest.json">
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
      <div class="container">
        <!-- # Paste your Header Content from here -->
        <!-- # Header Five Layout -->
        <!-- # Copy the code from here ... -->
        <!-- Header Content -->
        <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
          <!-- Logo Wrapper -->
          <div class="logo-wrapper"><a href="page-home.html"><img src="{{  settings()->get('app_logo')  }}" alt=""></a></div>
          <!-- Navbar Toggler -->
          <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
        </div>
        <!-- # Header Five Layout End -->
      </div>
    </div>
    <!-- # Sidenav Left -->
    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-start" id="affanOffcanvas" data-bs-scroll="true" tabindex="-1" aria-labelledby="affanOffcanvsLabel">
      <button class="btn-close btn-close-white text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      <div class="offcanvas-body p-0">
        <!-- Side Nav Wrapper -->
        <div class="sidenav-wrapper">
          <!-- Sidenav Profile -->
          <div class="sidenav-profile bg-gradient">
            <div class="sidenav-style1"></div>
            <!-- User Thumbnail -->
            <div class="user-profile"><img src="{{ asset('affan') }}/img/bg-img/2.jpg" alt=""></div>
            <!-- User Info -->
            <div class="user-info">
              <h6 class="user-name mb-0">Affan Islam</h6><span>CEO, Designing World</span>
            </div>
          </div>
          <!-- Sidenav Nav -->
          <ul class="sidenav-nav ps-0">
            <li><a href="page-home.html"><i class="bi bi-house-door"></i>Home</a></li>
            <li><a href="elements.html"><i class="bi bi-folder2-open"></i>Elements<span class="badge bg-danger rounded-pill ms-2">220+</span></a></li>
            <li><a href="pages.html"><i class="bi bi-collection"></i>Pages<span class="badge bg-success rounded-pill ms-2">100+</span></a></li>
            <li><a href="#"><i class="bi bi-cart-check"></i>Shop</a>
              <ul>
                <li><a href="page-shop-grid.html">Shop Grid</a></li>
                <li><a href="page-shop-list.html">Shop List</a></li>
                <li><a href="page-shop-details.html">Shop Details</a></li>
                <li><a href="page-cart.html">Cart</a></li>
                <li><a href="page-checkout.html">Checkout</a></li>
              </ul>
            </li>
            <li><a href="settings.html"><i class="bi bi-gear"></i>Settings</a></li>
            <li>
              <div class="night-mode-nav"><i class="bi bi-moon"></i>Night Mode
                <div class="form-check form-switch">
                  <input class="form-check-input form-check-success" id="darkSwitch" type="checkbox">
                </div>
              </div>
            </li>
            <li><a href="page-login.html"><i class="bi bi-box-arrow-right"></i>Logout</a></li>
          </ul>
          <!-- Social Info -->
          <div class="social-info-wrap"><a href="#"><i class="bi bi-facebook"></i></a><a href="#"><i class="bi bi-twitter"></i></a><a href="#"><i class="bi bi-linkedin"></i></a></div>
          <!-- Copyright Info -->
          <div class="copyright-info">
            <p>2021 &copy; Made by<a href="#">Designing World</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="page-content-wrapper">
      <!-- Welcome Toast -->
      <div class="toast toast-autohide custom-toast-1 toast-success home-page-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000" data-bs-autohide="true">
        <div class="toast-body">
          <svg class="bi bi-bookmark-check text-white" width="30" height="30" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"></path>
            <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"></path>
          </svg>
          <div class="toast-text ms-3 me-2">
            <p class="mb-1 text-white">Welcome to Affan!</p><small class="d-block">Click the "Add to Home Screen" button &amp; enjoy it like an app.</small>
          </div>
        </div>
        <button class="btn btn-close btn-close-white position-absolute p-1" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <!-- Tiny Slider One Wrapper -->
      <div class="tiny-slider-one-wrapper">
        <div class="tiny-slider-one">
          <!-- Single Hero Slide -->
          <div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('affan') }}/img/bg-img/31.jpg')">
              <div class="h-100 d-flex align-items-center text-center">
                <div class="container">
                  <h3 class="text-white mb-1">Build with Bootstrap 5</h3>
                  <p class="text-white mb-4">Build fast, responsive sites with Bootstrap.</p><a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Hero Slide -->
          <div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('affan') }}/img/bg-img/33.jpg')">
              <div class="h-100 d-flex align-items-center text-center">
                <div class="container">
                  <h3 class="text-white mb-1">Vanilla JavaScript</h3>
                  <p class="text-white mb-4">The whole code is written with vanilla JS.</p><a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Hero Slide -->
          <div> 
            <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('affan') }}/img/bg-img/32.jpg')">
              <div class="h-100 d-flex align-items-center text-center">
                <div class="container">
                  <h3 class="text-white mb-1">PWA Ready</h3>
                  <p class="text-white mb-4">Click the "Add to Home Screen" button &amp; <br> enjoy it like an app.</p><a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Hero Slide -->
          <div> 
            <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('affan') }}/img/bg-img/33.jpg')">
              <div class="h-100 d-flex align-items-center text-center">
                <div class="container">
                  <h3 class="text-white mb-1">Lots of Elements &amp; Pages</h3>
                  <p class="text-white mb-4">Create your website in days, not months.</p><a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                </div>
              </div>
            </div>
          </div>
          <!-- Single Hero Slide -->
          <div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('{{ asset('affan') }}/img/bg-img/1.jpg')">
              <div class="h-100 d-flex align-items-center text-center">
                <div class="container">
                  <h3 class="text-white mb-1">Dark &amp; RTL Ready</h3>
                  <p class="text-white mb-4">You can use the Dark or <br> RTL mode of your choice.</p><a class="btn btn-creative btn-warning" href="#">Buy Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="pt-3"></div>
      <div class="container direction-rtl">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><img src="{{ asset('affan') }}/img/demo-img/pwa.png" alt=""></div>
                  <p class="mb-0">PWA Ready</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><img src="{{ asset('affan') }}/img/demo-img/bootstrap.png" alt=""></div>
                  <p class="mb-0">Bootstrap 5</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><img src="{{ asset('affan') }}/img/demo-img/js.png" alt=""></div>
                  <p class="mb-0">Vanilla JS</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card card-bg-img bg-img bg-overlay mb-3" style="background-image: url('{{ asset('affan') }}/img/bg-img/3.jpg')">
          <div class="card-body direction-rtl p-5">
            <h2 class="text-white">Reusable elements</h2>
            <p class="mb-4 text-white">More than 220+ reusable modern design elements. Just copy the code and paste it on your desired page.</p><a class="btn btn-warning" href="elements.html">All elements</a>
          </div>
        </div>
      </div>
      <div class="container direction-rtl">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><img src="{{ asset('affan') }}/img/demo-img/sass.png" alt=""></div>
                  <p class="mb-0">SCSS</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><img src="{{ asset('affan') }}/img/demo-img/pug.png" alt=""></div>
                  <p class="mb-0">PUG</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><img src="{{ asset('affan') }}/img/demo-img/npm.png" alt=""></div>
                  <p class="mb-0">NPM</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card bg-primary mb-3 bg-img" style="background-image: url('{{ asset('affan') }}/img/core-img/1.png')">
          <div class="card-body direction-rtl p-5">
            <h2 class="text-white">Ready pages</h2>
            <p class="mb-4 text-white">Already designed more than 100+ pages for your needs. Such as - Authentication, Chats, eCommerce, Blog &amp; Miscellaneous pages.</p><a class="btn btn-warning" href="pages.html">All pages</a>
          </div>
        </div>
      </div>
      <div class="container direction-rtl">
        <div class="card mb-3">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><img src="{{ asset('affan') }}/img/demo-img/gulp.png" alt=""></div>
                  <p class="mb-0">Gulp 4</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><i class="bi bi-moon text-dark"></i></div>
                  <p class="mb-0">Dark Mode</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><i class="bi bi-box-arrow-left text-info"></i></div>
                  <p class="mb-0">RTL Ready</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="card mb-3">
          <div class="card-body">
            <h3>Customer Review</h3>
            <div class="testimonial-slide-three-wrapper">
              <div class="testimonial-slide3 testimonial-style3">
                <!-- Single Testimonial Slide -->
                <div class="single-testimonial-slide">
                  <div class="text-content"><span class="d-inline-block badge bg-warning mb-2"><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill"></i></span>
                    <h6 class="mb-2">The code looks clean, and the designs are excellent. I recommend.</h6><span class="d-block">Mrrickez, Themeforest</span>
                  </div>
                </div>
                <!-- Single Testimonial Slide -->
                <div class="single-testimonial-slide">
                  <div class="text-content"><span class="d-inline-block badge bg-warning mb-2"><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill"></i></span>
                    <h6 class="mb-2">All complete, <br> great craft.</h6><span class="d-block">Mazatlumm, Themeforest</span>
                  </div>
                </div>
                <!-- Single Testimonial Slide -->
                <div class="single-testimonial-slide">
                  <div class="text-content"><span class="d-inline-block badge bg-warning mb-2"><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill"></i></span>
                    <h6 class="mb-2">Awesome template! <br> Excellent support!</h6><span class="d-block">Vguntars, Themeforest</span>
                  </div>
                </div>
                <!-- Single Testimonial Slide -->
                <div class="single-testimonial-slide">
                  <div class="text-content"><span class="d-inline-block badge bg-warning mb-2"><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill me-1"></i><i class="bi bi-star-fill"></i></span>
                    <h6 class="mb-2">Nice modern design, <br> I love the product.</h6><span class="d-block">electroMEZ, Themeforest</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container direction-rtl">
        <div class="card">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray"><i class="bi bi-star text-warning"></i></div>
                  <p class="mb-0">Best Rated</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray">
                    <svg class="bi bi-award text-success" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z"></path>
                      <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"></path>
                    </svg>
                  </div>
                  <p class="mb-0">Elegant</p>
                </div>
              </div>
              <div class="col-4">
                <div class="feature-card mx-auto text-center">
                  <div class="card mx-auto bg-gray">
                    <svg class="bi bi-lightning-charge text-primary" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z"></path>
                    </svg>
                  </div>
                  <p class="mb-0">Trendsetter</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="pb-3"></div>
    </div>
    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
      <div class="container px-0">
        <!-- =================================== -->
        <!-- Paste your Footer Content from here -->
        <!-- =================================== -->
        <!-- Footer Content -->
        <div class="footer-nav position-relative">
          <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
            <li class="active"><a href="page-home.html">
                <svg class="bi bi-house" width="20" height="20" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"></path>
                  <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"></path>
                </svg><span>Home</span></a></li>
            <li><a href="pages.html">
                <svg class="bi bi-collection" width="20" height="20" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M14.5 13.5h-13A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5zm-13 1A1.5 1.5 0 0 1 0 13V6a1.5 1.5 0 0 1 1.5-1.5h13A1.5 1.5 0 0 1 16 6v7a1.5 1.5 0 0 1-1.5 1.5h-13zM2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z"></path>
                </svg><span>Pages</span></a></li>
            <li><a href="elements.html">
                <svg class="bi bi-folder2-open" width="20" height="20" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.56 2.311 1.184C7.985 3.648 8.48 4 9 4h4.5A1.5 1.5 0 0 1 15 5.5v.64c.57.265.94.876.856 1.546l-.64 5.124A2.5 2.5 0 0 1 12.733 15H3.266a2.5 2.5 0 0 1-2.481-2.19l-.64-5.124A1.5 1.5 0 0 1 1 6.14V3.5zM2 6h12v-.5a.5.5 0 0 0-.5-.5H9c-.964 0-1.71-.629-2.174-1.154C6.374 3.334 5.82 3 5.264 3H2.5a.5.5 0 0 0-.5.5V6zm-.367 1a.5.5 0 0 0-.496.562l.64 5.124A1.5 1.5 0 0 0 3.266 14h9.468a1.5 1.5 0 0 0 1.489-1.314l.64-5.124A.5.5 0 0 0 14.367 7H1.633z"></path>
                </svg><span>Elements</span></a></li>
            <li><a href="page-chat-users.html">
                <svg class="bi bi-chat-dots" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                  <path d="M2.165 15.803l.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z"></path>
                </svg><span>Chat</span></a></li>
            <li><a href="settings.html">
                <svg class="bi bi-gear" width="20" height="20" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"></path>
                  <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"></path>
                </svg><span>Settings</span></a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- All JavaScript Files -->
    <script src="{{ asset('affan') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('affan') }}/js/slideToggle.min.js"></script>
    <script src="{{ asset('affan') }}/js/internet-status.js"></script>
    <script src="{{ asset('affan') }}/js/tiny-slider.js"></script>
    <script src="{{ asset('affan') }}/js/baguetteBox.min.js"></script>
    <script src="{{ asset('affan') }}/js/countdown.js"></script>
    <script src="{{ asset('affan') }}/js/rangeslider.min.js"></script>
    <script src="{{ asset('affan') }}/js/vanilla-dataTables.min.js"></script>
    <script src="{{ asset('affan') }}/js/index.js"></script>
    <script src="{{ asset('affan') }}/js/magic-grid.min.js"></script>
    <script src="{{ asset('affan') }}/js/dark-rtl.js"></script>
    <script src="{{ asset('affan') }}/js/active.js"></script>
    <!-- PWA -->
    <script src="{{ asset('affan') }}/js/pwa.js"></script>
  </body>
</html>