<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-text mx-3">{{ __('RM BALTIM') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('account') || request()->is('account/*') || request()->is('transactions-today') || request()->query('today') == 1 ? 'active' : '' }}">
        <a class="nav-link" href="/account">
            <i class="fas fa-dollar-sign"></i>
            <span>{{ __('Transaksi Hari Ini') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->is('transactions') || request()->is('transactions/*') || request()->is('purchase/*') && !request()->is('purchase/create') && !request()->query('today') == 1 || request()->is('salary/*') && !request()->is('salary/create') && !request()->query('today') == 1 || request()->is('pos/*')  && !request()->is('pos/create') && !request()->query('today') == 1  ? 'active' : '' }}">
        <a class="nav-link" href="/transactions">
            <i class="fas fa-receipt"></i>
            <span>{{ __('Riwayat Transaksi') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi
    </div>

    @can('employee')
    <li class="nav-item {{ request()->is('pos/create') ? 'active' : '' }}">
        <a class="nav-link" href="/pos/create">
            <i class="fas fa-cash-register"></i>
            <span>{{ __('Kasir') }}</span></a>
    </li>
    @endcan

    <li class="nav-item {{ request()->is('purchase/create') ? 'active' : '' }}">
        <a class="nav-link" href="/purchase/create">
            <i class="fas fa-luggage-cart"></i>
            <span>{{ __('Pemesanan Bahan') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('otherpurchase') || request()->is('otherpurchase/*') ? 'active' : '' }}">
        <a class="nav-link" href="/otherpurchase/create">
            <i class="fas fa-money-check-alt"></i>
            <span>{{ __('Pembayaran Lain-lain') }}</span></a>
    </li>

    @can('admin')
        <li class="nav-item {{ request()->is('salary/create') ? 'active' : '' }}">
            <a class="nav-link" href="/salary/create">
                <i class="fas fa-hand-holding-usd"></i>
                <span>{{ __('Pembayaran Gaji') }}</span></a>
        </li>
    @endcan

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <li class="nav-item {{ request()->is('fnb') || request()->is('fnb/*') ? 'active' : '' }}">
        <a class="nav-link" href="/fnb">
            <i class="fas fa-utensils"></i>
            <span>{{ __('Menu') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('supplier') || request()->is('supplier/*') ? 'active' : '' }}">
        <a class="nav-link" href="/supplier">
            <i class="fas fa-warehouse"></i>
            <span>{{ __('Pemasok') }}</span></a>
    </li>
    @can('admin')
        <li class="nav-item {{ request()->is('employee') || request()->is('employee/*') && !request()->is('employee/'. auth()->user()->username .'/edit') ? 'active' : '' }}">
            <a class="nav-link" href="/employee">
                <i class="fas fa-users"></i>
                <span>{{ __('Akun Karyawan') }}</span></a>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Akuntansi
    </div>

    <li class="nav-item {{ request()->is('transactions-recap') ? 'active' : '' }}">
        <a class="nav-link" href="/transactions-recap">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>{{ __('Rekap Transaksi') }}</span></a>
    </li>

    @can('admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-scroll"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('report/posisi-keuangan') || request()->is('report/posisi-keuangan*') ? 'active' : '' }}" href="/report/posisi-keuangan">Posisi Keuangan</a>
                <a class="collapse-item {{ request()->is('report/laba-rugi') ? 'active' : '' }}" href="/report/laba-rugi">Laba Rugi</a>
                <a class="collapse-item {{ request()->is('report/calk') ? 'active' : '' }}" href="/report/calk">CALK</a>
            </div>
        </div>
    </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan Pengguna
    </div>

    <li class="nav-item {{ request()->is('employee/'. auth()->user()->username .'/edit') ? 'active' : '' }}">
        <a class="nav-link" href="/employee/{{ auth()->user()->username }}/edit">
            <i class="fas fa-user-cog"></i>
            <span>{{ __('Ubah Profil') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('change-password') || request()->is('employee-change-password/*') ? 'active' : '' }}">
        <a class="nav-link" href="/employee-change-password/{{ auth()->user()->username }}">
            <i class="fas fa-key"></i>
            <span>{{ __('Ubah Kata Sandi') }}</span></a>
    </li>

</ul>
