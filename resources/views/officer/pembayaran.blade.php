@extends('layout.officer')

@section('title', 'Data Pembayaran')

@section('content')
<div class="card shadow-sm border-0 rounded-4 p-4 bg-white animate__animated animate__fadeIn">
    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-2 mb-md-0">
            <i class="bi bi-receipt-cutoff me-2"></i> Data Pembayaran
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('officer.pembayaran.create') }}" class="btn btn-primary rounded-3 shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-primary text-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Warga</th>
                        <th>Iuran</th>
                        <th>Jumlah Bayar</th>
                        <th>Periode</th>
                        <th>Jumlah Periode</th>
                        <th>Tanggal Bayar</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-start">{{ $pembayaran->warga->nama ?? '-' }}</td>
                            <td>{{ $pembayaran->iuran->nama_iuran ?? '-' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    Rp{{ number_format($pembayaran->iuran->jumlah, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-25 text-dark">
                                    {{ ucfirst($pembayaran->iuran->periode ?? '-') }}
                                </span>
                            </td>
                            <td>{{ $pembayaran->jumlah_periode }}</td>
                            <td>{{ $pembayaran->tanggal_bayar }}</td>
                            <td class="fw-bold text-success">
                                Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($pembayaran->status == 'lunas')
                                    <span class="badge bg-success bg-opacity-75">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('officer.pembayaran.edit', $pembayaran->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox me-2"></i> Belum ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse

                    {{-- Baris total --}}
                    <tr class="table-secondary fw-bold">
                        <td colspan="5" class="text-end">Total:</td>
                        <td>{{ $totalPeriode }}</td>
                        <td></td>
                        <td>Rp{{ number_format($totalJumlah, 0, ',', '.') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
</div>



{{-- Tambahkan animasi CSS --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
