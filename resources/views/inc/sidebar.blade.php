<nav class="sidebar sidebar-offcanvas sticky-top" id="sidebar">
    <ul class="nav">
        @if(@auth()->user()->username == 'fahmi')
            <li class="nav-item">
                <router-link class="nav-link" to="/index-api">
                    <span class="menu-title text-dark">API</span>
                    <i class="fa fa-cog menu-icon"></i>
                </router-link>
            </li>    
        @endif
        @can('admin')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#admin_panel" aria-expanded="false" >
                <span class="menu-title">Admin Panel</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-crosshairs-gps menu-icon"></i>
            </a>
            <div class="collapse" id="admin_panel">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        {{-- <router-link class="nav-link" to="/index-user">Index User</router-link>  --}}
                    </li>
                    <li class="nav-item"> 
                        <router-link class="nav-link" to="/index-produk">Index Produk</router-link>
                    </li>
                    <li class="nav-item"> 
                        <router-link class="nav-link" to="/index-kategori">Index Kategori</router-link>
                    </li>
                </ul>
            </div>
        </li>
        @endcan
        <li class="nav-item">
            <router-link class="nav-link" to="/">
                <span class="menu-title text-dark">Produk Penjualan</span>
                <i class="fa fa-shopping-bag menu-icon"></i>
            </router-link>
        </li>
        @can('user')
        <li class="nav-item">
            <router-link class="nav-link " to="/troli">
                <span class="menu-title text-dark">Troli Belanjaan</span>
                <i class="mdi mdi-cart menu-icon"></i>
            </router-link>
        </li>
        @endcan
        @auth
        <li class="nav-item">
            <router-link class="nav-link " to="/transaksi">
                <span class="menu-title text-dark">Transaksi</span>
                <i class="fa fa-money menu-icon"></i>
            </router-link>
        </li>
        {{-- <li class="nav-item">
            <router-link class="nav-link " to="/pengaturan">
                <span class="menu-title text-dark">Pengaturan</span>
                <i class="fa fa-cog menu-icon"></i>
            </router-link>
        </li> --}}
        {{-- <li class="nav-item">
            <router-link class="nav-link " to="/profil">
                <span class="menu-title text-dark">Profile</span>
                <i class="fa fa-user menu-icon"></i>
            </router-link>
        </li> --}}

        <li class="nav-item d-md-none d-sm-block">
            <form action=" {{route('logout')}} " method="POST" class="nav-link">
                @csrf
                <button type="submit" class="menu-title " style="background: none; border: none; padding: 0">
                    Logout
                </button>
                <i class="mdi mdi-power menu-icon"></i> 
            </form>
        </li>
        @endauth

        @guest
        <li class="nav-item">
            <router-link class="nav-link " to="/login">
                <span class="menu-title text-dark">Login</span>
                <i class="mdi mdi-login menu-icon"></i>
            </router-link>
        </li>
        @endguest
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
