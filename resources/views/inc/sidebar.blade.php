<nav class="sidebar sidebar-offcanvas sticky-top" id="sidebar">
    <ul class="nav">

        <li class="nav-item">
            <router-link class="nav-link" to="/">
                <span class="menu-title text-dark">Daftar Barang</span>
                <i class="mdi mdi-boombox menu-icon"></i>
            </router-link>
        </li>
        @can('admin')
        <li class="nav-item">
            <router-link class="nav-link " to="/admin-page">
                <span class="menu-title text-dark">page  admin</span>
                <i class="mdi mdi-boombox menu-icon"></i>
            </router-link>
        </li>
        @endcan
        {{-- @can('client')
        <li class="nav-item">
            <a class="nav-link " href=" ">
                <span class="menu-title text-dark">Belanjaan / Cart</span>
                <i class="mdi mdi-cart menu-icon"></i>
            </a>
        </li>
        @endcan
        @can('admin')
        <li class="nav-item">
            <a class="nav-link " href=" ">
                <span class="menu-title text-dark">Daftar Kategori</span>
                <i class="mdi mdi-filter menu-icon"></i>
            </a>
        </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link " href=" ">
                <span class="menu-title text-dark">Daftar Transaksi</span>
                <i class="mdi mdi-history menu-icon"></i>
            </a>
        </li>
        @can('admin')
        <li class="nav-item">
            <a class="nav-link " href=" ">
                <span class="menu-title text-dark">Daftar User</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link " href=" ">
                <span class="menu-title text-dark">Manajemen Profile</span>
                <i class="mdi mdi-format-list-bulleted-type menu-icon"></i>
            </a>
        </li> --}}
    </ul>
</nav>
