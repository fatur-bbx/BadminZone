@extends('dashboard.template.layout')
@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header">
                Tabel Persediaan
                <div class="float-end">

                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalImport">Import</button>

                    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog"
                        aria-labelledby="modalImportTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalImportTitle">Import Data Persediaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="formImportPersediaan" method="POST" action="{{ route('persediaan.import') }}"
                                    enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Pilih File Excel (.xlsx, .xls)</label>
                                            <input class="form-control" type="file" id="file" name="file"
                                                accept=".xlsx, .xls" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-sm btn-primary" href="{{ route('persediaan.export') }}">Export</a>
                    <br>
                    <button class="btn btn-sm btn-primary w-100 mt-1" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">Tambah Data</button>

                    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Persediaan</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="formTambahPersediaan" method="POST" action="{{ route('persediaan.store') }}">
                                    <div class="modal-body">
                                        @csrf
                                        <label for="nama_barang" class="text-dark">Nama Barang</label>
                                        <input type="text" name="nama_barang" id="nama_barang" class="form-control"
                                            placeholder="Masukkan nama barang" required>
                                        <div class="mb-2"></div>
                                        <label for="harga_pcs" class="text-dark">Harga</label>
                                        <input type="number" name="harga_pcs" id="harga_pcs" class="form-control"
                                            placeholder="Masukkan harga barang" required>
                                        <div class="mb-2"></div>
                                        <label for="jumlah_persediaan" class="text-dark">Jumlah</label>
                                        <input type="number" name="jumlah_persediaan" id="jumlah_persediaan"
                                            class="form-control" placeholder="Masukkan jumlah" required>
                                        <div class="mb-2"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </form>
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
                            <th>Nama Barang</th>
                            <th>Harga / 1 Pcs</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nomor = 1;
                        @endphp
                        @foreach ($persediaan as $item)
                            <tr>
                                <td>{{ $nomor++ }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>Rp. {{ $item->harga_pcs }},-</td>
                                <td>{{ $item->jumlah_persediaan }}</td>
                                <td>
                                    <a class="btn btn-datatable btn-icon btn-transparent-purple me-2"
                                        data-bs-toggle="modal" data-bs-target="#modalEdit{{ $nomor }}"><i
                                            data-feather="edit"></i></a>

                                    <div class="modal fade" id="modalEdit{{ $nomor }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Data
                                                        Persediaan</h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form id="formUpdatePersediaan{{ $nomor }}" method="POST"
                                                    action="{{ route('persediaan.update', $item->id_persediaan) }}">
                                                    <div class="modal-body">
                                                        @csrf
                                                        @method('PUT')
                                                        <label for="nama_barang" class="text-dark">Nama Barang</label>
                                                        <input type="text" name="nama_barang" id="nama_barang"
                                                            class="form-control" placeholder="Masukkan nama barang"
                                                            value="{{ $item->nama_barang }}" required>
                                                        <div class="mb-2"></div>
                                                        <label for="harga_pcs" class="text-dark">Harga</label>
                                                        <input type="number" name="harga_pcs" id="harga_pcs"
                                                            class="form-control" placeholder="Masukkan harga barang"
                                                            value="{{ $item->harga_pcs }}" required>
                                                        <div class="mb-2"></div>
                                                        <label for="jumlah_persediaan" class="text-dark">Jumlah</label>
                                                        <input type="number" name="jumlah_persediaan"
                                                            id="jumlah_persediaan" class="form-control"
                                                            placeholder="Masukkan jumlah"
                                                            value="{{ $item->jumlah_persediaan }}" required>
                                                        <div class="mb-2"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button class="btn btn-primary" type="submit">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('persediaan.destroy', $item->id_persediaan) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-datatable btn-icon btn-transparent-red"><i
                                                data-feather="trash-2"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
