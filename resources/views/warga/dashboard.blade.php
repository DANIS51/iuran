@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-primary mb-4">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </h2>

    {{-- Statistik Ringkas --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center bg-light">
                <i class="bi bi-people-fill text-primary fs-1 mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $totalWarga }}</h5>
                <p class="text-muted mb-0">Total Warga</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center bg-light">
                <i class="bi bi-cash-coin text-success fs-1 mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $totalIuran }}</h5>
                <p class="text-muted mb-0">Total Iuran</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center bg-light">
                <i class="bi bi-wallet2 text-warning fs-1 mb-2"></i>
                <h5 class="fw-bold mb-0">Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</h5>
                <p class="text-muted mb-0">Total Pembayaran</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-center bg-light">
                <i class="bi bi-check2-circle text-success fs-1 mb-2"></i>
                <h5 class="fw-bold mb-0">{{ $pembayaranLunas }}</h5>
                <p class="text-muted mb-0">Pembayaran Lunas</p>
            </div>
        </div>
    </div>

    {{-- Tabel Pembayaran Terbaru --}}
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-clock-history me-2"></i> Pembayaran Terbaru
        </div>
        <div class="card-body">
            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Warga</th>
                        <th>Iuran</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaranTerbaru as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->warga->nama ?? '-' }}</td>
                            <td>{{ $p->iuran->nama_iuran ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
                            <td>Rp{{ number_format($p->jumlah, 0, ',', '.') }}</td>
                            <td>
                                @if($p->status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Belum ada pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
