@extends('dashboard.template.layout')
@section('content')
    <div class="container-xl px-4 mt-n10">
        <div class="card mb-4">
            <div class="card-header">
                Tabel Pengguna
                <div class="float-end">
                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalImport">Import</button>
                    <a class="btn btn-sm btn-primary" href="{{ route('users.export') }}">Export</a>
                    <br>
                    <button class="btn btn-sm btn-primary w-100 mt-1" type="button" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Pengguna</button>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->level == 0 ? 'Admin' : 'User' }}</td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-purple" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}"><i data-feather="edit"></i></button>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
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

    <!-- Modal Import -->
    <div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImportTitle">Import Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel (.xlsx, .xls)</label>
                            <input class="form-control" type="file" id="file" name="file" accept=".xlsx, .xls" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahTitle">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="0">Admin</option>
                                <option value="1">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pengguna -->
    @foreach ($users as $user)
        <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-labelledby="modalEditTitle{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditTitle{{ $user->id }}">Edit Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name{{ $user->id }}" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email{{ $user->id }}" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password{{ $user->id }}" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                                <input type="password" class="form-control" id="password{{ $user->id }}" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation{{ $user->id }}" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation{{ $user->id }}" name="password_confirmation">
                            </div>
                            <div class="mb-3">
                                <label for="level{{ $user->id }}" class="form-label">Level</label>
                                <select class="form-control" id="level{{ $user->id }}" name="level" required>
                                    <option value="0" {{ $user->level == 0 ? 'selected' : '' }}>Admin</option>
                                    <option value="1" {{ $user->level == 1 ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
