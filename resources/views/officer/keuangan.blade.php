@extends('layout.officer')

@section('title', 'Data Keuangan')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-wallet2 me-2"></i> Data Keuangan
    </h3>

    {{-- Alert Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tombol Tambah --}}
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('officer.keuangan.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
            </a>
        </div>
        <div class="text-end">
            <small class="text-muted">Breakdown: Pembayaran = Rp{{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}; Kas Masuk = Rp{{ number_format($totalMasukKeuangan ?? 0, 0, ',', '.') }}; Net Keuangan = Rp{{ number_format($keuanganNet ?? 0, 0, ',', '.') }}</small>
        </div>
    </div>

    {{-- Tabel Keuangan --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Jumlah (Rp)</th>
                        <th>Keterangan</th>
                        <th>Pembayaran ID</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keuangans as $index => $k)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y') }}</td>
                            <td>
                                @if ($k->tipe === 'masuk')
                                    <span class="badge bg-success">Masuk</span>
                                @else
                                    <span class="badge bg-danger">Keluar</span>
                                @endif
                            </td>
                            <td class="{{ $k->tipe === 'masuk' ? 'text-success' : 'text-danger' }}">
                                @if ($k->tipe === 'masuk')
                                    Rp{{ number_format($k->jumlah, 0, ',', '.') }}
                                @else
                                    -Rp{{ number_format($k->jumlah, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>{{ $k->keterangan ?? '-' }}</td>
                            <td>{{ $k->pembayaran_id ?? '-' }}</td>
                            <td>
                                {{--  <a href="{{ route('keuangan.edit', $k->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>  --}}
                                <form action="{{ route('officer.keuangan.destroy', $k->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data keuangan.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3" class="text-end">Total Pembayaran (masuk):</th>
                        <th colspan="4" class="text-success">
                            Rp{{ number_format($totalPembayaran ?? 0, 0, ',', '.') }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total Kas Masuk:</th>
                        <th colspan="4" class="text-success">
                            Rp{{ number_format($totalMasukKeuangan ?? 0, 0, ',', '.') }}
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-end">Total Uang Keluar:</th>
                        <th colspan="4" class="text-danger">
                            Rp{{ number_format($totalKeluar, 0, ',', '.') }}
                        </th>
                    </tr>
                    <tr class="fw-bold table-primary">
                        <th colspan="3" class="text-end">Saldo Akhir:</th>
                        <th colspan="4" class="text-dark">
                            Rp{{ number_format($saldoAkhir, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
