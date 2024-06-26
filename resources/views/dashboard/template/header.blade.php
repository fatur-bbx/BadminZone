@if(Request::is('dashboard*'))
    <header class="py-10 mb-4 bg-gradient-primary-to-secondary">
        <div class="container-xl px-4">
            <div class="text-center">
                <h1 class="text-white">Selamat datang di dashboard BadminZone</h1>
                <p class="lead mb-0 text-white-50">Sebuah website manajemen atau dashboard untuk pengelolaan sistem persediaan barang, pengeluaran, dan pendapatan.</p>
            </div>
        </div>
    </header>
@elseif(Request::is('pendapatan*'))
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="filter"></i></div>
                            Pendapatan
                        </h1>
                        <div class="page-header-subtitle mt-3">Halaman ini menampilkan daftar semua pendapatan yang telah dicatat dalam sistem. Setiap entri pendapatan mencakup informasi detail seperti jenis pendapatan, barang terkait, harga, jumlah, deskripsi, dan tanggal pendapatan.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
@elseif(Request::is('pengeluaran*'))
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="filter"></i></div>
                            Pengeluaran
                        </h1>
                        <div class="page-header-subtitle mt-3">Halaman ini menampilkan daftar semua pengeluaran yang telah dicatat dalam sistem. Setiap entri pendapatan mencakup informasi detail seperti jenis pengeluaran, barang terkait, harga, jumlah, deskripsi, dan tanggal pengeluaran.</div>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endif