<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
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
                    Pemesanan
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
        </ul>
    </div>
</nav>