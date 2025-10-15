@extends('layout.admin')

@section('title', 'Data Pembayaran')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-receipt-cutoff me-2"></i> Data Pembayaran
    </h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nama Warga</th>
                        <th>Iuran</th>
                        <th>Periode</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah</th>
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
                            <td>{{ $pembayaran->iuran->periode ?? '-' }}</td>
                            <td>{{ $pembayaran->tanggal_bayar }}</td>
                            <td>Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if($pembayaran->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
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
    </div>
</div>
@endsection
