@extends('dashboard.template.layout')
@section('content')
<div class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">
            Tabel Pengeluaran
            <div class="float-end">
                <button class="btn btn-sm btn-primary">Import</button>
                <button class="btn btn-sm btn-primary">Export</button>
                <br>
                <button class="btn btn-sm btn-primary w-100 mt-1" type="button" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>

                <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Pengeluaran</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formTambahPendapatan" method="POST" action="{{ route('pendapatan.store') }}">
                                    @csrf
                                    <label for="jenis_pendapatan" class="text-dark">Jenis Pendapatan</label>
                                    <select name="jenis_pendapatan" id="jenis_pendapatan" class="form-control">
                                        <option value="0">Penjualan</option>
                                        <option value="1">Sewa</option>
                                    </select>
                                    <div class="mb-2"></div>
                                    <label for="harga" class="text-dark">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan harga barang">
                                    <div class="mb-2"></div>
                                    <label for="jumlah" class="text-dark">Jumlah</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukkan jumlah">
                                    <div class="mb-2"></div>
                                    <label for="deskripsi" class="text-dark">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Masukkan deskripsi"></textarea>
                                    <div class="mb-2"></div>
                                    <label for="tanggal_pendapatan" class="text-dark">Tanggal Pendapatan</label>
                                    <input type="date" name="tanggal_pendapatan" id="tanggal_pendapatan" class="form-control">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $nomor = 1
                    @endphp
                    @foreach($pengeluaran as $item)
                    <tr>
                        <td>{{ $nomor++ }}</td>
                        <td>{{ $item->tanggal_pengeluaran }}</td>
                        <td>
                            @if ($item->jenis_pengeluaran == 1)
                                Operasional
                            @else
                                Non-Operasional
                            @endif
                        </td>
                        <td>
                            @if ($item->persediaan)
                                {{ $item->persediaan->nama_barang }}
                            @else
                                {{ $item->deskripsi }}
                            @endif
                        </td>
                        <td>Rp. {{ $item->harga }},-</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp. {{ $item->jumlah*$item->harga }},-</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                            <a class="btn btn-datatable btn-icon btn-transparent-purple me-2"><i data-feather="edit"></i></a>
                            <form action="{{ route('pendapatan.destroy', $item->id_pengeluaran) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-datatable btn-icon btn-transparent-red"><i data-feather="trash-2"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endsection
