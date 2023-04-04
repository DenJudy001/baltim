{{-- <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/">
                    <span data-feather="home"></span>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('supplier','supplier/create','supplier/'.($supplier->id ?? '').'/edit') ? 'active' : '' }}" aria-current="page" href="/supplier">
                    Pemasok
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('purchase/create') ? 'active' : '' }}" aria-current="page" href="/purchase/create">
                    Pemesanan Bahan/Produk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('otherpurchase/create') ? 'active' : '' }}" aria-current="page" href="/otherpurchase/create">
                    Pembayaran Lain-lain 
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('account') ? 'active' : '' }}" aria-current="page" href="/account">
                    Pencatatan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('employee', 'employee/create') ? 'active' : '' }}" aria-current="page" href="/employee">
                    Karyawan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('salary/create') ? 'active' : '' }}" aria-current="page" href="/salary/create">
                    Upah Karyawan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('fnb', 'fnb/create') ? 'active' : '' }}" aria-current="page" href="/fnb">
                    Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('pos', 'pos/create') ? 'active' : '' }}" aria-current="page" href="/pos/create">
                    POS
                </a>
            </li>
        </ul>
    </div>
</nav> --}}


<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-text mx-3">{{ __('RM BALTIM') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('account') || request()->is('account/*') ? 'active' : '' }}">
        <a class="nav-link" href="/account">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Catatan Keuangan') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <span>{{ __('Manajemen') }}</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ request()->is('employee') || request()->is('employee/*') ? 'active' : '' }}" href="/employee"> <i class="fa fa-briefcase mr-2"></i> {{ __('Akun Karyawan') }}</a>
                <a class="collapse-item {{ request()->is('supplier') || request()->is('supplier/*') ? 'active' : '' }}" href="/supplier"><i class="fa fa-briefcase mr-2"></i> {{ __('Pemasok') }}</a>
                <a class="collapse-item {{ request()->is('fnb') || request()->is('fnb/*') ? 'active' : '' }}" href="/fnb"> <i class="fa fa-user mr-2"></i> {{ __('Menu') }}</a>
            </div>
        </div>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pemasukan
    </div>

    <li class="nav-item {{ request()->is('pos') || request()->is('pos/*') ? 'active' : '' }}">
        <a class="nav-link" href="/pos/create">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Kasir') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengeluaran
    </div>

    <li class="nav-item {{ request()->is('purchase') || request()->is('purchase/*') ? 'active' : '' }}">
        <a class="nav-link" href="/purchase/create">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Pemesanan Bahan/Barang') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('otherpurchase') || request()->is('otherpurchase/*') ? 'active' : '' }}">
        <a class="nav-link" href="/otherpurchase/create">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Pembayaran Lain-lain') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('salary') || request()->is('salary/*') ? 'active' : '' }}">
        <a class="nav-link" href="/salary/create">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Gaji Karyawan') }}</span></a>
    </li>


</ul>
