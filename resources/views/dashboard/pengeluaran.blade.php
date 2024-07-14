@extends('dashboard.template.layout')
@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header">
                Tabel Pengeluaran
                <div class="float-end">
                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalImport">Import</button>

                    <div class="modal fade" id="modalImport" tabindex="-1" role="dialog"
                        aria-labelledby="modalImportTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalImportTitle">Import Data Pengeluaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="formImportPengeluaran" method="POST" action="{{ route('pengeluaran.import') }}"
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
                    <a class="btn btn-sm btn-primary" href="{{ route('pengeluaran.export') }}">Export</a>
                    <br>
                    <button class="btn btn-sm btn-primary w-100 mt-1" type="button" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">Tambah Data</button>

                    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Pengeluaran</h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="formTambahPengeluaran" method="POST" action="{{ route('pengeluaran.store') }}">
                                    <div class="modal-body">
                                        @csrf
                                        <label for="jenis_pengeluaran_tambah" class="text-dark">Jenis Pengeluaran</label>
                                        <select name="jenis_pengeluaran_tambah" id="jenis_pengeluaran_tambah"
                                            class="form-control">
                                            <option value="">Pilih Jenis Pengeluaran</option>
                                            <option value="1">Operasional</option>
                                            <option value="2">Non-Operasional</option>
                                        </select>
                                        <div class="mb-2"></div>
                                        <div id="fieldBarangTambah">
                                            <label for="barang" class="text-dark">Barang</label>
                                            <select name="barang" id="barang" class="form-control">
                                                <option value="">Pilih Barang</option>
                                                @foreach ($persediaan as $barang)
                                                    <option value="{{ $barang->id_persediaan }}"
                                                        data-harga="{{ $barang->harga_pcs }}">{{ $barang->nama_barang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="mb-2"></div>
                                        </div>
                                        <label for="harga" class="text-dark">Harga</label>
                                        <input type="number" name="harga" id="harga" class="form-control"
                                            placeholder="Masukkan harga barang" readonly>
                                        <div class="mb-2"></div>
                                        <label for="jumlah" class="text-dark">Jumlah</label>
                                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                                            placeholder="Masukkan jumlah">
                                        <div class="mb-2"></div>
                                        <label for="deskripsi_tambah" class="text-dark">Deskripsi</label>
                                        <textarea name="deskripsi_tambah" id="deskripsi_tambah" class="form-control" placeholder="Masukkan deskripsi"></textarea>
                                        <div class="mb-2"></div>
                                        <label for="tanggal_pengeluaran" class="text-dark">Tanggal Pengeluaran</label>
                                        <input type="date" name="tanggal_pengeluaran" id="tanggal_pengeluaran"
                                            class="form-control">
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
                            $nomor = 1;
                        @endphp
                        @foreach ($pengeluaran as $item)
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
                                <td>Rp. {{ $item->jumlah * $item->harga }},-</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>
                                    <a class="btn btn-datatable btn-icon btn-transparent-purple me-2" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $nomor }}"><i data-feather="edit"></i></a>
                                    <div class="modal fade" id="modalEdit{{ $nomor }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Data
                                                        Pengeluaran</h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form id="formEditPengeluaran{{ $nomor }}" method="POST"
                                                    action="{{ route('pengeluaran.update', $item->id_pengeluaran) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="nomor" value="{{ $nomor }}">
                                                    <div class="modal-body">
                                                        <label for="jenis_pengeluaran_edit_{{ $nomor }}"
                                                            class="text-dark">Jenis
                                                            Pengeluaran</label>
                                                        <select name="jenis_pengeluaran_edit_{{ $nomor }}"
                                                            id="jenis_pengeluaran_edit_{{ $nomor }}"
                                                            class="form-control">
                                                            <option value="">Pilih Jenis Pengeluaran</option>
                                                            <option value="1"
                                                                {{ $item->jenis_pengeluaran == 1 ? 'selected' : '' }}>
                                                                Operasional</option>
                                                            <option value="2"
                                                                {{ $item->jenis_pengeluaran == 2 ? 'selected' : '' }}>
                                                                Non-Operasional</option>
                                                        </select>
                                                        <div class="mb-2"></div>
                                                        <div id="fieldBarangEdit">
                                                            <label for="barang_edit_{{ $nomor }}"
                                                                class="text-dark">Barang</label>
                                                            <select name="barang_edit_{{ $nomor }}"
                                                                id="barang_edit_{{ $nomor }}"
                                                                class="form-control">
                                                                <option value="">Pilih Barang</option>
                                                                @foreach ($persediaan as $barang)
                                                                    <option value="{{ $barang->id_persediaan }}"
                                                                        {{ $item->barang == $barang->id_persediaan ? 'selected' : '' }}
                                                                        data-harga="{{ $barang->harga_pcs }}">
                                                                        {{ $barang->nama_barang }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="mb-2"></div>
                                                        </div>
                                                        <label for="harga_edit_{{ $nomor }}"
                                                            class="text-dark">Harga</label>
                                                        <input type="number" name="harga_edit_{{ $nomor }}"
                                                            id="harga_edit_{{ $nomor }}" class="form-control"
                                                            placeholder="Masukkan harga barang"
                                                            value="{{ $item->harga }}" readonly>
                                                        <div class="mb-2"></div>
                                                        <label for="jumlah_edit_{{ $nomor }}"
                                                            class="text-dark">Jumlah</label>
                                                        <input type="number" name="jumlah_edit_{{ $nomor }}"
                                                            id="jumlah_edit_{{ $nomor }}" class="form-control"
                                                            placeholder="Masukkan jumlah" value="{{ $item->jumlah }}">
                                                        <div class="mb-2"></div>
                                                        <label for="deskripsi_edit_{{ $nomor }}"
                                                            class="text-dark">Deskripsi</label>
                                                        <textarea name="deskripsi_edit_{{ $nomor }}" id="deskripsi_edit_{{ $nomor }}" class="form-control"
                                                            placeholder="Masukkan deskripsi">{{ $item->deskripsi }}</textarea>
                                                        <div class="mb-2"></div>
                                                        <label for="tanggal_pengeluaran_edit_{{ $nomor }}"
                                                            class="text-dark">Tanggal
                                                            Pengeluaran</label>
                                                        <input type="date"
                                                            name="tanggal_pengeluaran_edit_{{ $nomor }}"
                                                            id="tanggal_pengeluaran_edit_{{ $nomor }}"
                                                            class="form-control"
                                                            value="">
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

                                    <form action="{{ route('pengeluaran.destroy', $item->id_pengeluaran) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-datatable btn-icon btn-transparent-red"><i
                                                data-feather="trash-2"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <script>
                                $(document).ready(function() {
                                    $('#jenis_pengeluaran_edit_{{ $nomor }}').on('change', function() {
                                        if ($(this).val() == '2') {
                                            $('#fieldBarangEdit{{ $nomor }}').show();
                                            $('#deskripsi_edit_{{ $nomor }}').attr('placeholder', 'Masukkan deskripsi');
                                            $('#harga_edit_{{ $nomor }}').prop('readonly', true);
                                        } else {
                                            $('#fieldBarangEdit{{ $nomor }}').hide();
                                            $('#deskripsi_edit_{{ $nomor }}').attr('placeholder',
                                                'Contoh : Keperluan Pembersih Lantai');
                                            $('#harga_edit_{{ $nomor }}').prop('readonly', false);
                                        }
                                    });

                                    $('#jenis_pengeluaran_edit_{{ $nomor }}').trigger('change');

                                    $('#barang_edit_{{ $nomor }}').on('change', function() {
                                        var harga = $(this).find(':selected').data('harga');
                                        $('#harga_edit_{{ $nomor }}').val(harga);
                                    });

                                    let tanggalPengeluaran = new Date('{{ $item->tanggal_pengeluaran }}');
                                    let formattedDate = tanggalPengeluaran.toISOString().slice(0, 10);
                                    document.getElementById('tanggal_pengeluaran_edit_{{ $nomor }}').value = formattedDate;

                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            $('#jenis_pengeluaran_tambah').on('change', function() {
                if ($(this).val() == '2') {
                    $('#fieldBarangTambah').show();
                    $('#deskripsi_tambah').attr('placeholder', 'Masukkan deskripsi');
                    $('#harga').prop('readonly', true);
                } else {
                    $('#fieldBarangTambah').hide();
                    $('#deskripsi_tambah').attr('placeholder', 'Contoh : Keperluan Pembersih Lantai');
                    $('#harga').prop('readonly', false);
                }
            });

            $('#jenis_pengeluaran_tambah').trigger('change');

            $('#barang').on('change', function() {
                var harga = $(this).find(':selected').data('harga');
                $('#harga').val(harga);
            });
        });
    </script>
@endsection
