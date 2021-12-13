<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  @include('layouts.header', ['title' => @$title ?? config('app.name', 'Homecare - Tukangku')])

  @yield('style')
</head>
<body>
    @include('layouts.sidebar', [
      'menu' => @$menu ?? 'dashboard',
      'submenu' => @$submenu ?? 'grafik'
    ])

    @include('layouts.navbar')
    
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      @include('sweetalert::alert')
        @yield('content')

      <footer class="br-footer">
        <div class="footer-left">
          <div class="mg-b-2">Copyright &copy; <?=date('Y')?> Tukangku.</div>
          <div>By Tukangku.</div>
        </div>
        <div class="footer-right d-flex align-items-center">
          <span class="tx-uppercase mg-r-10">Share:</span>
          <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/bracket/intro"><i class="fa fa-facebook tx-20"></i></a>
          <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Bracket,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/bracket/intro"><i class="fa fa-twitter tx-20"></i></a>
        </div>
      </footer>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    @include('layouts.footer')

    @yield('scripts')
</body>
</html>
