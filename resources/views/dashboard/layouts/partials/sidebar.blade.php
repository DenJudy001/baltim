<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-text mx-3">{{ __('RM BALTIM') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('account') || request()->is('purchase/*') && !request()->is('purchase/create') || request()->is('salary/*') && !request()->is('salary/create') || request()->is('pos/*')  && !request()->is('pos/create')  ? 'active' : '' }}">
        <a class="nav-link" href="/account">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Catatan Keuangan') }}</span></a>
    </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pemasukan
    </div>

    <li class="nav-item {{ request()->is('fnb') || request()->is('fnb/*') ? 'active' : '' }}">
        <a class="nav-link" href="/fnb">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Menu') }}</span></a>
    </li>
    <li class="nav-item {{ request()->is('pos/create') ? 'active' : '' }}">
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

    <li class="nav-item {{ request()->is('supplier') || request()->is('supplier/*') ? 'active' : '' }}">
        <a class="nav-link" href="/supplier">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Pemasok') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('purchase/create') ? 'active' : '' }}">
        <a class="nav-link" href="/purchase/create">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Pemesanan Bahan/Barang') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('otherpurchase') || request()->is('otherpurchase/*') ? 'active' : '' }}">
        <a class="nav-link" href="/otherpurchase/create">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Pembayaran Lain-lain') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengaturan Pengguna
    </div>

    <li class="nav-item {{ request()->is('employee/'. auth()->user()->username .'/edit') ? 'active' : '' }}">
        <a class="nav-link" href="/employee/{{ auth()->user()->username }}/edit">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Ubah Profil') }}</span></a>
    </li>

    <li class="nav-item {{ request()->is('change-password') || request()->is('employee-change-password/*') ? 'active' : '' }}">
        <a class="nav-link" href="/employee-change-password/{{ auth()->user()->username }}">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Ubah Kata Sandi') }}</span></a>
    </li>

    @can('admin')
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Administrator
    </div>

    <li class="nav-item {{ request()->is('employee') || request()->is('employee/*') ? 'active' : '' }}">
        <a class="nav-link" href="/employee">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Akun Karyawan') }}</span></a>
    </li>
    
    <li class="nav-item {{ request()->is('salary/create') ? 'active' : '' }}">
        <a class="nav-link" href="/salary/create">
            <i class="fas fa-fw fa-cogs"></i>
            <span>{{ __('Gaji Karyawan') }}</span></a>
    </li>
    @endcan

    


</ul>
