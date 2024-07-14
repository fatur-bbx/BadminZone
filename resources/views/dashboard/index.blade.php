@extends('dashboard.template.layout')
@section('content')
    <!-- Main page content-->
    <div class="container-xl px-4">
        <h2 class="mt-5 mb-0">Ringkasan Keuangan</h2>
        <p>
            <?php
            $startDate = \Carbon\Carbon::now()->subWeek()->format('d F Y');
            $endDate = \Carbon\Carbon::now()->format('d F Y');
            echo $startDate . ' - ' . $endDate;
            ?>
        </p>
        <hr class="mt-0 mb-4" />
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Earnings (Monthly)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Earnings (Annual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="mt-5 mb-0">App Pages</h2>
        <p>App pages to cover common use pages to help build your app!</p>
        <hr class="mt-0 mb-4" />
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top Products</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($topProducts as $product)
                            @php
                                $productName = $product->persediaan
                                    ? $product->persediaan->nama_barang
                                    : $product->deskripsi;
                                $percentage = ($product->total_jumlah / $totalPenjualan) * 100;
                            @endphp
                            <h4 class="small font-weight-bold">{{ $productName }}, <span
                                    class="float-right">{{ $product->total_jumlah }} Penjualan</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%"
                                    aria-valuenow="{{ $product->total_jumlah }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Penyewaan Lapangan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pendapatan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="myChartPendapatan" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pengeluaran</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="myChartPengeluaran" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top Products</h6>
                    </div>
                    <div class="card-body">
                        @foreach ($lowStockProducts as $product)
                            <h4 class="small font-weight-bold">{{ $product->nama_barang }}, <span
                                    class="float-right">{{ 100 - number_format(($product->jumlah_persediaan / $totalJumlahPersediaan) * 100, 2) }}%
                                    Peringatan, Sisa Barang : {{ $product->jumlah_persediaan }}</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: {{ 100 - number_format(($product->jumlah_persediaan / $totalJumlahPersediaan) * 100, 2) }}%"
                                    aria-valuenow="{{ $totalJumlahPersediaan }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pengeluaran</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="financialChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            let fieldVisits = @json($fieldVisits);
            let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            let visitsLapangan1 = new Array(7).fill(0);
            let visitsLapangan2 = new Array(7).fill(0);

            fieldVisits.forEach(visit => {
                let dayIndex = days.indexOf(visit.day);
                if (visit.deskripsi === 'Lapangan 1') {
                    visitsLapangan1[dayIndex] = visit.count;
                } else if (visit.deskripsi === 'Lapangan 2') {
                    visitsLapangan2[dayIndex] = visit.count;
                }
            });

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: days,
                    datasets: [{
                            label: 'Lapangan 1',
                            data: visitsLapangan1,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Lapangan 2',
                            data: visitsLapangan2,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx = document.getElementById('myChartPendapatan').getContext('2d');

            var pendapatanBulanIni = @json($pendapatanBulanIni);
            var pendapatanBulanLalu = @json($pendapatanBulanLalu);

            var labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];

            var pendapatanChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pendapatan Bulan Lalu',
                            data: pendapatanBulanLalu.concat(Array(4 - pendapatanBulanLalu.length).fill(
                                0)), // Fill remaining weeks with 0
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            fill: true,
                            tension: 0.1
                        },
                        {
                            label: 'Pendapatan Bulan Ini',
                            data: pendapatanBulanIni.concat(Array(4 - pendapatanBulanIni.length).fill(
                                0)), // Fill remaining weeks with 0
                            borderColor: 'green',
                            backgroundColor: 'rgba(40, 167, 69, 0.5)',
                            fill: true,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx = document.getElementById('myChartPengeluaran').getContext('2d');

            var pengeluaranBulanIni = @json($pengeluaranBulanIni);
            var pengeluaranBulanLalu = @json($pengeluaranBulanLalu);

            var labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];

            var pengeluaranChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Pengeluaran Bulan Lalu',
                            data: pengeluaranBulanLalu.concat(Array(4 - pengeluaranBulanLalu.length)
                                .fill(0)), // Fill remaining weeks with 0
                            borderColor: 'red',
                            backgroundColor: 'rgba(255, 0, 0, 0.5)',
                            fill: true,
                            tension: 0.1
                        },
                        {
                            label: 'Pengeluaran Bulan Ini',
                            data: pengeluaranBulanIni.concat(Array(4 - pengeluaranBulanIni.length).fill(
                                0)), // Fill remaining weeks with 0
                            borderColor: 'orange',
                            backgroundColor: 'rgba(255, 165, 0, 0.5)',
                            fill: true,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            var data = {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    data: {!! json_encode($pendapatanPerBulan) !!},
                }, {
                    label: 'Pengeluaran',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    data: {!! json_encode($pengeluaranPerBulan) !!},
                }]
            };

            var config = {
                type: 'bar',
                data: data,
                options: {
                    indexAxis: 'x',
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah',
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan',
                            }
                        }
                    }
                }
            };

            const financialChart = new Chart(
                document.getElementById('financialChart'),
                config
            );
        });
    </script>
@endsection
