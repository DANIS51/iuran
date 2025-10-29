@extends('layout.officer')

@section('title', 'Data Pembayaran')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-dark mb-4">
        <i class="bi bi-wallet2 me-2"></i> Data Pembayaran
    </h3>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tombol tambah --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-secondary">Daftar Semua Pembayaran</h5>
        <a href="{{ route('officer.pembayaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
        </a>
    </div>

    {{-- Tabel --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-0">
                <thead class="table-dark text-white">
                    <tr>
                        <th>#</th>
                        <th>Nama Warga</th>
                        <th>Iuran</th>
                        <th>Jumlah Periode</th>
                        <th>Jumlah Bayar</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pembayaran->warga->nama ?? '-' }}</td>
                            <td>{{ $pembayaran->iuran->nama_iuran ?? '-' }}</td>
                            <td>{{ $pembayaran->jumlah_periode ?? 0 }}</td>
                            <td>Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $pembayaran->tanggal_bayar }}</td>
                            <td>
                                @if ($pembayaran->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('officer.pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('officer.pembayaran.destroy', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Ringkasan total --}}
        <div class="card-footer bg-light text-end">
            <strong>Total Pembayaran:</strong> Rp{{ number_format($totalJumlah, 0, ',', '.') }}
        </div>
    </div>
</div>
@endsection
