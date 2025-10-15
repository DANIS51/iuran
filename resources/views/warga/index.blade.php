@extends('layout.admin')

@section('title', 'Data Warga')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-people-fill me-2"></i> Data Warga
        </h3>
        <a href="{{ route('warga.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Warga
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Data Warga --}}
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th width="5%">#</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Jenis Kelamin</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wargas as $index => $warga)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $warga->nama }}</td>
                            <td>{{ $warga->alamat }}</td>
                            <td>{{ $warga->no_telepon ?? '-' }}</td>
                            <td>{{ $warga->jenis_kelamin }}</td>
                            <td class="text-center">
                                <a href="{{ route('warga.edit', $warga->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square">Ubah</i>
                                </a>
                                <form action="{{ route('warga.destroy', $warga->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash3">Hapus</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data warga.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
