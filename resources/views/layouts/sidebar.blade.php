<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span></span>Tukangku<span></span></a></div>
<div class="br-sideleft overflow-y-auto">
    <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
    <div class="br-sideleft-menu">
        <a href="#" class="br-menu-link @if ($menu == 'dashboard') active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                <span class="menu-item-label">Dashboard</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ url('/') }}"
                    class="nav-link @if ($submenu == 'graphic') active @endif">Grafik</a></li>
        </ul>
        <a href="#" class="br-menu-link @if ($menu == 'master') active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-soup-can-outline tx-24"></i>
                <span class="menu-item-label">Master</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('services') }}" class="nav-link @if ($submenu == 'services') active @endif">Data
                    Jasa</a></li>
            <li class="nav-item"><a href="{{ route('employees') }}" class="nav-link @if ($submenu == 'employees') active @endif">Data
                    Tukang</a></li>
            <li class="nav-item"><a href="{{ route('services_categories') }}"
                    class="nav-link @if ($submenu == 'services_category') active @endif">Data Kategori</a></li>
            <li class="nav-item"><a href="{{ route('banners') }}" class="nav-link @if ($submenu == 'banners') active @endif">Data
                    Banner</a></li>
        </ul>
        {{-- <a href="card-dashboard.html" class="br-menu-link">
      <div class="br-menu-item">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Cards &amp; Widgets</span>
      </div><!-- menu-item -->
    </a><!-- br-menu-link --> --}}
        <a href="#" class="br-menu-link @if ($menu == 'report') active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-ios-pie-outline tx-24"></i>
                <span class="menu-item-label">Laporan</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('report_service') }}"
                    class="nav-link @if ($submenu == 'service') active @endif">Laporan Jasa</a></li>
            <li class="nav-item"><a href="{{ route('report_consumen') }}"
                    class="nav-link @if ($submenu == 'consumen') active @endif">Laporan Seluruh Penjual</a></li>
        </ul>
        <a href="#" class="br-menu-link @if ($menu == 'users') active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon ion-ios-gear-outline tx-24"></i>
                <span class="menu-item-label">Management User</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('users') }}" class="nav-link @if ($submenu == 'user_datas') active @endif">Data
                    User</a></li>
            <li class="nav-item"><a href="{{ route('user_logs') }}" class="nav-link @if ($submenu == 'user_logs') active @endif">Log
                    User</a></li>
            <li class="nav-item"><a href="{{ route('roles') }}" class="nav-link @if ($submenu == 'user_roles') active @endif">Role
                    Akses</a></li>
        </ul>
        <a href="{{ route('consumen_users') }}" class="br-menu-link @if ($menu == 'consumen_users') active @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon ion-person-stalker tx-20"></i>
                <span class="menu-item-label">Pendaftaran Konsumen</span>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <a href="#" class="br-menu-link @if ($menu == 'consumen') active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-bag tx-24"></i>
                <span class="menu-item-label">Pembeli / Konsumen</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('transactions') }}"
                    class="nav-link @if ($submenu == 'transactions') active @endif">View User Pembeli</a></li>
            <li class="nav-item"><a href="{{ route('payments') }}"
                    class="nav-link @if ($submenu == 'payments') active @endif">Transaksi Pembeli</a></li>
            <li class="nav-item"><a href="{{ route('gps_logs') }}" class="nav-link @if ($submenu == 'gps_logs') active @endif">Log
                    GPS Pembeli</a></li>
            <li class="nav-item">
                <a href="{{ route('complains') }}" class="nav-link @if ($submenu == 'complain') active @endif">Complains</a>
            </li>
        </ul>
        <a href="#" class="br-menu-link @if ($menu == 'chatting') active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-ios-chatboxes-outline tx-20"></i>
                <span class="menu-item-label">Chatting</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('chatting_consumen') }}" class="nav-link @if ($submenu == 'chat_consumen') active @endif">Chatting Consumen</a></li>
            <li class="nav-item"><a href="{{ route('notifications') }}" class="nav-link @if ($submenu == 'notification') active @endif">Notification</a></li>
        </ul>
        <a href="#" class="br-menu-link @if ($menu == 'history') active show-sub @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon icon ion-document tx-24"></i>
                <span class="menu-item-label">History</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub nav flex-column">
            <li class="nav-item"><a href="{{ route('history_employee') }}"
                    class="nav-link @if ($submenu == 'employee') active @endif">History Pekerjaan Tukang</a></li>
            <li class="nav-item"><a href="{{ route('history_transaction') }}"
                    class="nav-link @if ($submenu == 'transaction') active @endif">History Orderan Konsumen</a></li>
        </ul>
        <a href="{{ route('profile_edit') }}" class="br-menu-link @if ($menu == 'profile') active @endif">
            <div class="br-menu-item">
                <i class="menu-item-icon ion-ios-person tx-20"></i>
                <span class="menu-item-label">Profile</span>
            </div><!-- menu-item -->
        </a><!-- br-menu-link -->
    </div><!-- br-sideleft-menu -->
</div><!-- br-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->
