<div class="sidenav-menu">
    <div class="nav accordion" id="accordionSidenav">
        <!-- Sidenav Menu Heading (Core)-->
        <div class="sidenav-menu-heading">Core</div>
        <!-- Sidenav Accordion (Dashboard)-->
        <a class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <div class="nav-link-icon"><i data-feather="activity"></i></div>
            Dashboards
        </a>
        <a class="nav-link {{ Request::is('pendapatan*') ? 'active' : '' }}" href="{{ route('pendapatan') }}">
            <div class="nav-link-icon"><i data-feather="grid"></i></div>
            Pendapatan
        </a>
        <a class="nav-link {{ Request::is('pengeluaran*') ? 'active' : '' }}" href="{{ route('pengeluaran') }}">
            <div class="nav-link-icon"><i data-feather="grid"></i></div>
            Pengeluaran
        </a>
        <a class="nav-link {{ Request::is('persediaan*') ? 'active' : '' }}" href="{{ route('persediaan') }}">
            <div class="nav-link-icon"><i data-feather="grid"></i></div>
            Persediaan
        </a>
    </div>
</div>
<!-- Sidenav Footer-->
<div class="sidenav-footer">
    <div class="sidenav-footer-content">
        <div class="sidenav-footer-subtitle">Logged in as:</div>
        <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
    </div>
</div>