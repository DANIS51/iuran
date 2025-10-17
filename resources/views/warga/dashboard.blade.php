@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    {{-- Judul Halaman --}}
    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-speedometer2 text-primary fs-1 me-2"></i>
        <h2 class="fw-bold mb-0 text-dark">Dashboard</h2>
    </div>

    {{-- Statistik Utama --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card text-center p-3 rounded-4 border-0 shadow-sm">
                <i class="bi bi-people-fill text-primary fs-1 mb-2"></i>
                <h4 class="fw-bold text-dark mb-1">{{ $totalWarga }}</h4>
                <p class="text-muted mb-0">Total Warga</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-3 rounded-4 border-0 shadow-sm">
                <i class="bi bi-cash-coin text-success fs-1 mb-2"></i>
                <h4 class="fw-bold text-dark mb-1">{{ $totalIuran }}</h4>
                <p class="text-muted mb-0">Total Iuran</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-3 rounded-4 border-0 shadow-sm">
                <i class="bi bi-wallet2 text-info fs-1 mb-2"></i>
                <h4 class="fw-bold text-dark mb-1">Rp{{ number_format($totalPembayaran, 0, ',', '.') }}</h4>
                <p class="text-muted mb-0">Total Pembayaran</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center p-3 rounded-4 border-0 shadow-sm">
                <i class="bi bi-check2-circle text-primary fs-1 mb-2"></i>
                <h4 class="fw-bold text-dark mb-1">{{ $pembayaranLunas }}</h4>
                <p class="text-muted mb-0">Pembayaran Lunas</p>
            </div>
        </div>
    </div>

    {{-- Statistik Keuangan --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card stat-card border-0 rounded-4 p-4 text-center shadow-sm bg-gradient bg-opacity-10">
                <i class="bi bi-graph-up text-success fs-1 mb-2"></i>
                <h4 class="fw-bold text-dark mb-1">Rp{{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                <p class="text-muted mb-0">Total Pemasukan</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stat-card border-0 rounded-4 p-4 text-center shadow-sm bg-gradient bg-opacity-10">
                <i class="bi bi-graph-down text-danger fs-1 mb-2"></i>
                <h4 class="fw-bold text-dark mb-1">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                <p class="text-muted mb-0">Total Pengeluaran</p>
            </div>
        </div>
    </div>

    {{-- Tabel Pembayaran Terbaru --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-primary text-white fw-bold d-flex align-items-center rounded-top-4">
            <i class="bi bi-clock-history me-2 fs-5"></i> Pembayaran Terbaru
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
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
                                <td class="fw-semibold text-dark">{{ $p->warga->nama ?? '-' }}</td>
                                <td>{{ $p->iuran->nama_iuran ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
                                <td>Rp{{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    @if($p->status == 'lunas')
                                        <span class="badge bg-success bg-opacity-75 px-3 py-2">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-2">Belum</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">Belum ada pembayaran terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Style tambahan --}}
<style>
body {
    background-color: #ffffff;
}
.stat-card {
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
