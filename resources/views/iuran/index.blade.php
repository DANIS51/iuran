@extends('layout.admin')

@section('title', 'Data Iuran')

@section('content')
<div class="card shadow border-0 rounded-4 p-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="fw-bold text-primary">Daftar Iuran</h4>
        <a href="{{ route('iuran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Iuran
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Iuran</th>
                <th>Jumlah</th>
                <th>Periode</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($iurans as $index => $iuran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $iuran->nama_iuran }}</td>
                <td>Rp {{ number_format($iuran->jumlah, 0, ',', '.') }}</td>
                <td>{{ ucfirst($iuran->periode) }}</td>
                <td>{{ $iuran->keterangan ?? '-' }}</td>
                <td>
                    <a href="{{ route('iuran.edit', $iuran->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('iuran.destroy', $iuran->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted">Belum ada data iuran</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
