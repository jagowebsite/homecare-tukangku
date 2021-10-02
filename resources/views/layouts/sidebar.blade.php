<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span></span>Homecare<span></span></a></div>
<div class="br-sideleft overflow-y-auto">
  <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
  <div class="br-sideleft-menu">
    <a href="index.html" class="br-menu-link active">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
        <span class="menu-item-label">Dashboard</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub nav flex-column">
      <li class="nav-item"><a href="navigation.html" class="nav-link">Grafik</a></li>
    </ul>
    <a href="mailbox.html" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-soup-can-outline tx-24"></i>
        <span class="menu-item-label">Master</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub nav flex-column">
      <li class="nav-item"><a href="{{route('services')}}" class="nav-link">Data Jasa</a></li>
      <li class="nav-item"><a href="{{route('employees')}}" class="nav-link">Data Tukang</a></li>
      <li class="nav-item"><a href="{{route('services_categories')}}" class="nav-link">Data Kategori</a></li>
      <li class="nav-item"><a href="{{route('banners')}}" class="nav-link">Data Banner</a></li>
    </ul>
    {{-- <a href="card-dashboard.html" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Cards &amp; Widgets</span>
      </div><!-- menu-item -->
    </a><!-- br-menu-link --> --}}
    <a href="#" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-pie-outline tx-24"></i>
        <span class="menu-item-label">Laporan</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub nav flex-column">
      <li class="nav-item"><a href="accordion.html" class="nav-link">Laporan Jasa</a></li>
      <li class="nav-item"><a href="alerts.html" class="nav-link">Laporan Seluruh Penjual</a></li>
    </ul>
    <a href="#" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon ion-ios-gear-outline tx-24"></i>
        <span class="menu-item-label">Management User</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub nav flex-column">
      <li class="nav-item"><a href="{{route('users')}}" class="nav-link">Data User</a></li>
      <li class="nav-item"><a href="{{route('user_logs')}}" class="nav-link">Log User</a></li>
      <li class="nav-item"><a href="{{route('roles')}}" class="nav-link">Role Akses</a></li>
    </ul>
    <a href="{{route('consumen_users')}}" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon ion-person-stalker tx-20"></i>
        <span class="menu-item-label">Pendaftaran Konsumen</span>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <a href="#" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-bag tx-24"></i>
        <span class="menu-item-label">Pembeli / Konsumen</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub nav flex-column">
      <li class="nav-item"><a href="{{route('transactions')}}" class="nav-link">View User Pembeli</a></li>
      <li class="nav-item"><a href="{{route('payments')}}" class="nav-link">Transaksi Pembeli</a></li>
      <li class="nav-item"><a href="{{route('gps_logs')}}" class="nav-link">Log GPS Pembeli</a></li>
    </ul>
    <a href="#" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-chatboxes-outline tx-20"></i>
        <span class="menu-item-label">Chatting</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub nav flex-column">
      <li class="nav-item"><a href="table-basic.html" class="nav-link">Chatting Consumen</a></li>
    </ul>
    <a href="#" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-document tx-24"></i>
        <span class="menu-item-label">History</span>
        <i class="menu-item-arrow fa fa-angle-down"></i>
      </div><!-- menu-item -->
    </a><!-- br-menu-link -->
    <ul class="br-menu-sub nav flex-column">
      <li class="nav-item"><a href="map-google.html" class="nav-link">History Pekerjaan Tukang</a></li>
      <li class="nav-item"><a href="map-leaflet.html" class="nav-link">History Orderan Tukang</a></li>
    </ul>
  </div><!-- br-sideleft-menu -->
</div><!-- br-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->
